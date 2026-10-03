<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Microsoft 365 brings your favorite apps together with Copilot',
                'answer' => 'Microsoft 365 includes familiar apps like Word, Excel, PowerPoint, Outlook, Teams, and OneDrive, plus Copilot experiences that help you create, find, summarize, and get things done across your work. With a Microsoft account, you can use <a href="https://word.new" target="_blank" class="text-[#0067b8] dark:text-sky-400 underline font-semibold">Word</a>, <a href="https://excel.new" target="_blank" class="text-[#0067b8] dark:text-sky-400 underline font-semibold">Excel</a>, and <a href="https://powerpoint.new" target="_blank" class="text-[#0067b8] dark:text-sky-400 underline font-semibold">PowerPoint</a> in your browser for free. For desktop apps, more storage, and additional premium features, you can explore Microsoft 365 plans.',
                'sort_order' => 1,
                'is_default_open' => true,
                'is_active' => true,
            ],
            [
                'question' => 'Copilot helps you quickly get oriented and move work forward',
                'answer' => 'Microsoft 365 Copilot Chat brings together work context through natural conversation, helping you understand priorities, catch up on progress, clarify intent, explore options, and identify next steps without breaking your flow.',
                'sort_order' => 2,
                'is_default_open' => false,
                'is_active' => true,
            ],
            [
                'question' => 'Microsoft Copilot keeps work and personal experiences separate',
                'answer' => 'Microsoft Copilot brings personal and work experiences into one simpler place while keeping them separate. Work stays work, and personal stays personal, so your work data, chats, files, and organizational protections remain separate from your personal Copilot experience.',
                'sort_order' => 3,
                'is_default_open' => false,
                'is_active' => true,
            ],
            [
                'question' => 'Copilot works with Microsoft 365 security protections',
                'answer' => 'Copilot is built with security, privacy, and compliance in mind. It respects existing permissions and enterprise protections, helping safeguard your content, accounts, and collaboration while you work.',
                'sort_order' => 4,
                'is_default_open' => false,
                'is_active' => true,
            ],
            [
                'question' => 'You\'re in control of when you use AI',
                'answer' => 'Copilot responds when you choose to use it. You stay in control of when and how you use AI features, and your existing privacy and security settings continue to apply.',
                'sort_order' => 5,
                'is_default_open' => false,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
