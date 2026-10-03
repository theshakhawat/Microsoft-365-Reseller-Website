<?php

namespace Database\Seeders;

use App\Models\AiFeature;
use Illuminate\Database\Seeder;

class AiFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'badge'       => 'Deep Research',
                'title'       => 'Researcher',
                'description' => 'Save time and streamline complex research with Researcher in Microsoft Copilot, delivering detailed, source-cited AI-powered reports from the web.',
                'image'       => 'assets/img/ai-features/Researcher.png',
                'link_url'    => '#plans',
                'link_text'   => 'See Copilot plans',
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'badge'       => 'Analytics',
                'title'       => 'Analyst',
                'description' => 'Make sense of your data quickly with Analyst in Microsoft Copilot, delivering comprehensive analysis and visual data storytelling from your documents with ease.',
                'image'       => 'assets/img/ai-features/Analyst.png',
                'link_url'    => '#plans',
                'link_text'   => 'See Copilot plans',
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'badge'       => 'Creative Media',
                'title'       => 'OneDrive AI Restyle',
                'description' => 'Refresh your photos with OneDrive AI Restyle, using AI-powered tools to easily transform images with new looks and creative visual styles.',
                'image'       => 'assets/img/ai-features/OneDrive AI Restyle.png',
                'link_url'    => '#plans',
                'link_text'   => 'See Copilot plans',
                'sort_order'  => 3,
                'is_active'   => true,
            ],
            [
                'badge'       => 'Content Editing',
                'title'       => 'Edit with Copilot',
                'description' => "Rewrite and refine your work right where you're editing — polish documents in Word, update tables in Excel, clean up structure in PowerPoint, and adjust tone in Outlook.",
                'image'       => 'assets/img/ai-features/Edit with Copilot.png',
                'link_url'    => '#plans',
                'link_text'   => 'See Copilot plans',
                'sort_order'  => 4,
                'is_active'   => true,
            ],
            [
                'badge'       => 'Audio AI',
                'title'       => 'Audio Overviews',
                'description' => 'Turn your notes into engaging audio with AI-powered overviews in Microsoft Copilot Notebooks, so you can listen and connect with your content in a whole new way.',
                'image'       => 'assets/img/ai-features/Audio Overviews.png',
                'link_url'    => '#plans',
                'link_text'   => 'See Copilot plans',
                'sort_order'  => 5,
                'is_active'   => true,
            ],
            [
                'badge'       => 'Collaboration',
                'title'       => 'AI Rewrite in Teams',
                'description' => 'Communicate more clearly with Copilot in Microsoft Teams, helping you easily rewrite and refine messages for the right professional tone, length, and clarity.',
                'image'       => 'assets/img/ai-features/AI Rewrite in Teams.png',
                'link_url'    => '#plans',
                'link_text'   => 'See Copilot plans',
                'sort_order'  => 6,
                'is_active'   => true,
            ],
            [
                'badge'       => 'Expanded Power',
                'title'       => 'More AI Usage & Creation',
                'description' => 'Microsoft 365 Personal and Family plans include higher limits in the Copilot app for image creation, chat, and select advanced features like Voice and Vision.',
                'image'       => 'assets/img/ai-features/More AI usage.png',
                'link_url'    => '#plans',
                'link_text'   => 'See Copilot plans',
                'sort_order'  => 7,
                'is_active'   => true,
            ],
        ];

        foreach ($features as $feature) {
            AiFeature::updateOrCreate(
                ['title' => $feature['title']],
                $feature
            );
        }
    }
}
