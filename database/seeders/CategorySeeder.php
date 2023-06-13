<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name_en' => 'Science and Research',
            'name_ar' => 'العلوم والبحوث',
            'description_en' => 'This category covers the latest scientific findings and research on climate change, including studies on the causes, impacts, and potential solutions.',
            'description_ar' => 'تغطي هذه الفئة أحدث النتائج العلمية والبحوث حول التغيرات المناخية، بما في ذلك الدراسات حول الأسباب والآثار والحلول المحتملة.',
        ]);

        Category::create([
            'name_en' => 'Climate Policy and Politics',
            'name_ar' => 'السياسات والسياسة المناخية',
            'description_en' => 'This category covers the policy and political debates surrounding climate change, including government actions, international agreements, and political movements.',
            'description_ar' => 'تغطي هذه الفئة النقاشات السياسية والسياسات المحيطة بالتغيرات المناخية، بما في ذلك الإجراءات الحكومية والاتفاقيات الدولية والحركات السياسية.',
        ]);

        Category::create([
            'name_en' => 'Climate Solutions',
            'name_ar' => 'حلول المناخ',
            'description_en' => 'This category covers innovative solutions to reduce greenhouse gas emissions, such as renewable energy, electric vehicles, and carbon capture technologies.',
            'description_ar' => 'تغطي هذه الفئة الحلول المبتكرة للحد من انبعاثات الغازات الدفيئة، مثل الطاقة المتجددة والمركبات الكهربائية وتقنيات الاحتجاز الكربوني.',
        ]);

        Category::create([
            'name_en' => 'Climate Action and Advocacy',
            'name_ar' => 'العمل والترويج للمناخ',
            'description_en' => 'This category covers stories of individuals and organizations taking action to address climate change, including community initiatives, grassroots movements, and activism.',
            'description_ar' => 'تغطي هذه الفئة قصص الأفراد والمنظمات الذين يتخذون إجراءات لمعالجة التغيرات المناخية، بما في ذلك المبادرات المجتمعية والحركات الأساسية والنضالية.',
        ]);

        Category::create([
            'name_en' => 'Climate Education and Awareness',
            'name_ar' => 'التعليم والوعي المناخي',
            'description_en' => 'This category covers efforts to educate people about climate change, including the science, impacts, and ways to take action.',
            'description_ar' => 'تغطي هذه الفئة الجهود المبذولة لتثقيف الناس حول التغيرات المناخية، بما في ذلك العلوم والآثار والطرق لاتخاذ إجراءات.',
        ]);

        Category::create([
            'name_en' => 'Climate Justice and Equity',
            'name_ar' => 'العدالة والإنصاف المناخي',
            'description_en' => 'This category covers the disproportionate impacts of climate change on marginalized communities and efforts to promote equity and justice in climate action.',
            'description_ar' => 'تغطي هذه الفئة الآثار غير المتكافئة للتغيرات المناخية على المجتمعات المهمشة والجهود المبذولة لتعزيز العدالة والإنصاف في العمل المناخي.',
        ]);

        Category::create([
            'name_en' => 'Climate-Related Eventsand News',
            'name_ar' => 'الأحداث والأخبار المتعلقة بالمناخ',
            'description_en' => 'This category covers the latest news and events related to climate change, including extreme weather events, policy announcements, and international summits.',
            'description_ar' => 'تغطي هذه الفئة آخر الأخبار والأحداث المتعلقة بالتغيرات المناخية، بما في ذلك الأحداث الجوية الشديدة والإعلانات السياسية والقمم الدولية.',
        ]);
    }
}
