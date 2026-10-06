<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class CleanUploadedFilesSeeder extends Seeder
{
    /**
     * Run the database seeds to clean all user-uploaded files and media.
     */
    public function run(): void
    {
        // 1. Clean storage/app/public directory (e.g. settings, tickets, avatars)
        $storagePublicPath = storage_path('app/public');
        if (File::isDirectory($storagePublicPath)) {
            $directories = File::directories($storagePublicPath);
            foreach ($directories as $dir) {
                File::deleteDirectory($dir);
            }

            $files = File::files($storagePublicPath);
            foreach ($files as $file) {
                if ($file->getFilename() !== '.gitignore') {
                    File::delete($file->getPathname());
                }
            }
        }

        // 2. Clean public/uploads directory (e.g. payment-methods, brands, custom uploads)
        $publicUploadsPath = public_path('uploads');
        if (File::isDirectory($publicUploadsPath)) {
            $directories = File::directories($publicUploadsPath);
            foreach ($directories as $dir) {
                File::deleteDirectory($dir);
            }

            $files = File::files($publicUploadsPath);
            foreach ($files as $file) {
                if ($file->getFilename() !== '.gitignore') {
                    File::delete($file->getPathname());
                }
            }
        }

        // 3. Ensure storage link is active
        if (!File::exists(public_path('storage'))) {
            try {
                Artisan::call('storage:link');
            } catch (\Throwable $e) {
                // Silently ignore if already exists or permission
            }
        }

        // 4. Clear settings and application cache
        Cache::flush();

        if (isset($this->command)) {
            $this->command->info('🧹 Cleaned all user-uploaded files and reset media storage.');
        }
    }
}
