<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminLogController extends Controller
{
    /**
     * Display parsed & filterable Laravel logs.
     */
    public function index(Request $request): View
    {
        $logPath = storage_path('logs/laravel.log');
        $selectedFile = $request->query('file', 'laravel.log');
        
        // Find all log files in storage/logs
        $allFiles = [];
        if (File::exists(storage_path('logs'))) {
            $files = File::files(storage_path('logs'));
            foreach ($files as $file) {
                if ($file->getExtension() === 'log') {
                    $allFiles[] = [
                        'name' => $file->getFilename(),
                        'size' => $this->formatBytes($file->getSize()),
                        'modified_at' => date('Y-m-d H:i:s', $file->getMTime()),
                    ];
                }
            }
        }

        $targetPath = storage_path("logs/{$selectedFile}");
        if (!File::exists($targetPath)) {
            $targetPath = $logPath;
            $selectedFile = 'laravel.log';
        }

        $fileStats = [
            'exists'      => File::exists($targetPath),
            'name'        => $selectedFile,
            'size'        => File::exists($targetPath) ? $this->formatBytes(File::size($targetPath)) : '0 KB',
            'raw_bytes'   => File::exists($targetPath) ? File::size($targetPath) : 0,
            'modified_at' => File::exists($targetPath) ? date('M d, Y H:i:s', File::lastModified($targetPath)) : 'N/A',
            'path'        => $targetPath,
        ];

        $filterLevel = strtoupper(trim((string) $request->query('level', 'ALL')));
        $searchQuery = trim((string) $request->query('search', ''));
        $viewMode = $request->query('mode', 'parsed'); // parsed or raw

        $parsedLogs = [];
        $rawContent = '';
        $counts = [
            'total'    => 0,
            'error'    => 0,
            'warning'  => 0,
            'info'     => 0,
            'debug'    => 0,
            'critical' => 0,
            'emergency'=> 0,
        ];

        if (File::exists($targetPath)) {
            $content = File::get($targetPath);
            
            if ($viewMode === 'raw') {
                // Get last 500 lines for raw display to avoid browser overload
                $lines = explode("\n", $content);
                $rawContent = implode("\n", array_slice($lines, -600));
            }

            $parsedLogs = $this->parseLogContent($content, $filterLevel, $searchQuery, $counts);
        }

        return view('admin.logs.index', compact(
            'allFiles',
            'selectedFile',
            'fileStats',
            'parsedLogs',
            'rawContent',
            'counts',
            'filterLevel',
            'searchQuery',
            'viewMode'
        ));
    }

    /**
     * Download the specified log file.
     */
    public function download(Request $request): BinaryFileResponse|RedirectResponse
    {
        $file = $request->query('file', 'laravel.log');
        $cleanName = basename($file);
        $path = storage_path("logs/{$cleanName}");

        if (!File::exists($path)) {
            return back()->with('error', "Log file '{$cleanName}' not found.");
        }

        return response()->download($path, $cleanName);
    }

    /**
     * Clear / Empty the log file contents.
     */
    public function clear(Request $request): RedirectResponse
    {
        $file = $request->input('file', 'laravel.log');
        $cleanName = basename($file);
        $path = storage_path("logs/{$cleanName}");

        if (!File::exists($path)) {
            return back()->with('error', "Log file '{$cleanName}' does not exist.");
        }

        try {
            File::put($path, '');
            return back()->with('success', "Log file '{$cleanName}' has been cleared successfully.");
        } catch (\Throwable $e) {
            return back()->with('error', "Failed to clear log file: " . $e->getMessage());
        }
    }

    /**
     * Parse log file string into structured entries.
     */
    private function parseLogContent(string $content, string $filterLevel, string $searchQuery, array &$counts): array
    {
        $pattern = '/^\[(?<timestamp>\d{4}-\d{2}-\d{2}[T ]\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:[\+-]\d{2}:\d{2})?)\]\s+(?<env>\w+)\.(?<level>[A-Z]+):/m';
        
        preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);

        if (empty($matches[0])) {
            return [];
        }

        $entries = [];
        $totalMatches = count($matches[0]);

        for ($i = 0; $i < $totalMatches; $i++) {
            $timestamp = $matches['timestamp'][$i][0];
            $env = $matches['env'][$i][0];
            $level = strtoupper($matches['level'][$i][0]);

            // Track stats
            $levelKey = strtolower($level);
            if (isset($counts[$levelKey])) {
                $counts[$levelKey]++;
            }
            $counts['total']++;

            $startOffset = $matches[0][$i][1];
            $endOffset = ($i + 1 < $totalMatches) ? $matches[0][$i + 1][1] : strlen($content);
            $fullBlock = substr($content, $startOffset, $endOffset - $startOffset);

            // Extract message and stack trace
            $firstLineEnd = strpos($fullBlock, "\n");
            if ($firstLineEnd !== false) {
                $header = substr($fullBlock, 0, $firstLineEnd);
                $messageAndTrace = substr($fullBlock, $firstLineEnd + 1);
            } else {
                $header = $fullBlock;
                $messageAndTrace = '';
            }

            // Clean message from header
            $colonPos = strpos($header, "{$level}:");
            $message = ($colonPos !== false) ? trim(substr($header, $colonPos + strlen($level) + 1)) : $header;

            // Check if stack trace exists
            $trace = '';
            $stackTracePos = strpos($messageAndTrace, '[stacktrace]');
            if ($stackTracePos !== false) {
                $trace = trim(substr($messageAndTrace, $stackTracePos));
                $messageExtra = trim(substr($messageAndTrace, 0, $stackTracePos));
                if (!empty($messageExtra)) {
                    $message .= "\n" . $messageExtra;
                }
            } elseif (!empty($messageAndTrace)) {
                $trace = trim($messageAndTrace);
            }

            // Apply level filter
            if ($filterLevel !== 'ALL' && $level !== $filterLevel) {
                continue;
            }

            // Apply search query filter
            if ($searchQuery !== '') {
                $needle = strtolower($searchQuery);
                if (!str_contains(strtolower($message), $needle) && !str_contains(strtolower($trace), $needle) && !str_contains(strtolower($timestamp), $needle)) {
                    continue;
                }
            }

            $entries[] = [
                'id'        => $i + 1,
                'timestamp' => $timestamp,
                'env'       => $env,
                'level'     => $level,
                'message'   => $message,
                'trace'     => $trace,
            ];
        }

        // Return latest logs first
        return array_reverse(array_slice($entries, -200));
    }

    /**
     * Format bytes into human-readable string.
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
