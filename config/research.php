<?php

return [
    'page' => [
        'title' => 'Research & Publications',
        'seo_title' => 'Research & Publications — Anmol Pushjai Goel',
        'meta_description' => 'Research, articles, essays and recommended studies by Anmol Pushjai Goel.',
        'og_image' => 'images/research/research-hero-collage.jpg',
    ],

    'sections' => [
        'index' => [
            'name' => 'Index Hero',
            'type' => 'index',
            'sort_order' => 10,
            'fields' => [
                'kick' => ['label' => 'Kick line', 'type' => 'text', 'max' => 160],
                'heading' => ['label' => 'Heading', 'type' => 'text', 'max' => 180],
                'terminal_lines' => [
                    'label' => 'Terminal lines',
                    'type' => 'repeater',
                    'max_items' => 12,
                    'fields' => [
                        'text' => ['label' => 'Line', 'type' => 'text', 'max' => 120],
                    ],
                ],
                'note' => ['label' => 'Index note', 'type' => 'text', 'max' => 240],
                'background_image' => ['label' => 'Background image', 'type' => 'image'],
                'background_alt' => ['label' => 'Background alt text', 'type' => 'text', 'max' => 180],
            ],
            'content' => [
                'kick' => 'Anmol Pushjai Goel',
                'heading' => 'Research & Publications',
                'terminal_lines' => [
                    ['_key' => 'line-1', 'text' => '> reading markets…'],
                    ['_key' => 'line-2', 'text' => '> reading machines…'],
                    ['_key' => 'line-3', 'text' => '> reading institutions…'],
                    ['_key' => 'line-4', 'text' => '> reading people…'],
                ],
                'note' => '// a living index — new work is appended as it is published',
                'background_image' => 'images/research/research-hero-collage.jpg',
                'background_alt' => 'Research and publications collage',
            ],
        ],
        'lens' => [
            'name' => 'Methodology Lens',
            'type' => 'lens',
            'sort_order' => 20,
            'fields' => [
                'figure_caption' => ['label' => 'Figure caption', 'type' => 'text', 'max' => 120],
                'image' => ['label' => 'Lens image', 'type' => 'image'],
                'image_alt' => ['label' => 'Image alt text', 'type' => 'text', 'max' => 180],
                'eyebrow' => ['label' => 'Eyebrow', 'type' => 'text', 'max' => 120],
                'heading' => ['label' => 'Heading', 'type' => 'text', 'max' => 180],
                'description' => ['label' => 'Description', 'type' => 'textarea', 'max' => 1400],
                'credentials' => [
                    'label' => 'Credentials',
                    'type' => 'repeater',
                    'max_items' => 8,
                    'fields' => [
                        'label' => ['label' => 'Label', 'type' => 'text', 'max' => 40],
                        'text' => ['label' => 'Text', 'type' => 'text', 'max' => 220],
                    ],
                ],
            ],
            'content' => [
                'figure_caption' => 'fig.01 — the lens',
                'image' => 'images/research/sociology-psychology-technology-sign.jpg',
                'image_alt' => 'Sociology, Psychology, Technology',
                'eyebrow' => 'Methodology',
                'heading' => 'Three disciplines, one way of seeing.',
                'description' => 'This work is not engineering-first. It reads markets, machines and policy the way a social scientist reads people — for incentives, institutions and the quiet structures that decide what is possible.',
                'credentials' => [
                    ['_key' => 'cred-1', 'label' => 'BA', 'text' => 'Psychology · Panjab University, Chandigarh'],
                    ['_key' => 'cred-2', 'label' => 'MA', 'text' => 'Sociology · Jawaharlal Nehru University, New Delhi'],
                    ['_key' => 'cred-3', 'label' => 'MA', 'text' => 'Philosophy · Panjab University, Chandigarh'],
                ],
            ],
        ],
        'interlude' => [
            'name' => 'Interlude Quote',
            'type' => 'interlude',
            'sort_order' => 30,
            'fields' => [
                'eyebrow' => ['label' => 'Eyebrow', 'type' => 'text', 'max' => 120],
                'quote' => ['label' => 'Quote', 'type' => 'textarea', 'max' => 900],
                'source' => ['label' => 'Source line', 'type' => 'text', 'max' => 180],
                'background_image' => ['label' => 'Background image', 'type' => 'image'],
                'background_alt' => ['label' => 'Background alt text', 'type' => 'text', 'max' => 180],
            ],
            'content' => [
                'eyebrow' => 'fig.02 — at the intersection',
                'quote' => 'Technology alone is not enough. It is technology married to the humanities that yields the result that makes the heart sing.',
                'source' => 'The premise the research is built on',
                'background_image' => 'images/research/steve-jobs-floor.jpg',
                'background_alt' => 'Steve Jobs sitting with early computer equipment',
            ],
        ],
        'fields' => [
            'name' => 'Fields & Influences',
            'type' => 'fields',
            'sort_order' => 40,
            'fields' => [
                'eyebrow' => ['label' => 'Eyebrow', 'type' => 'text', 'max' => 120],
                'heading' => ['label' => 'Heading', 'type' => 'text', 'max' => 180],
                'items' => [
                    'label' => 'Field cards',
                    'type' => 'repeater',
                    'max_items' => 12,
                    'fields' => [
                        'figure_caption' => ['label' => 'Figure caption', 'type' => 'text', 'max' => 80],
                        'name' => ['label' => 'Name', 'type' => 'text', 'max' => 120],
                        'who' => ['label' => 'Person/discipline', 'type' => 'text', 'max' => 180],
                        'description' => ['label' => 'Description', 'type' => 'textarea', 'max' => 700],
                        'image' => ['label' => 'Image', 'type' => 'image'],
                        'image_alt' => ['label' => 'Image alt text', 'type' => 'text', 'max' => 180],
                    ],
                ],
            ],
            'content' => [
                'eyebrow' => 'The minds in the margins',
                'heading' => 'Who the work argues with.',
                'items' => [
                    ['_key' => 'field-1', 'figure_caption' => 'fig.03', 'name' => 'Markets', 'who' => 'Adam Smith · Political Economy', 'description' => 'Markets as moral systems — the invisible hand that still needs watching, and the political economy underneath every price.', 'image' => 'images/research/adam-smith-statue.jpg', 'image_alt' => 'Adam Smith statue'],
                    ['_key' => 'field-2', 'figure_caption' => 'fig.04', 'name' => 'Capital & Power', 'who' => 'Karl Marx · Critique', 'description' => 'Who owns, who labours, who decides — reading technology and policy through the ledger of power.', 'image' => 'images/research/karl-marx-portrait.jpg', 'image_alt' => 'Karl Marx portrait'],
                    ['_key' => 'field-3', 'figure_caption' => 'fig.05', 'name' => 'Revolution', 'who' => 'Che Guevara · Power', 'description' => 'The uncomfortable question of when systems must be broken rather than reformed.', 'image' => 'images/research/che-guevara-portrait.jpg', 'image_alt' => 'Che Guevara portrait'],
                    ['_key' => 'field-4', 'figure_caption' => 'fig.06', 'name' => 'Technology & Taste', 'who' => 'Steve Jobs · Craft', 'description' => 'Technology built at the intersection of the humanities — with conviction, not consensus.', 'image' => 'images/research/steve-jobs-portrait.jpg', 'image_alt' => 'Steve Jobs portrait'],
                    ['_key' => 'field-5', 'figure_caption' => 'fig.07', 'name' => 'The Public', 'who' => 'Sociology of the crowd', 'description' => 'A billion individuals who refuse to behave like one market.', 'image' => 'images/research/social-research-crowd.jpg', 'image_alt' => 'Illustration of a public crowd'],
                ],
            ],
        ],
        'footer' => [
            'name' => 'Research Footer',
            'type' => 'footer',
            'sort_order' => 50,
            'fields' => [
                'background_image' => ['label' => 'Background image', 'type' => 'image'],
                'background_alt' => ['label' => 'Background alt text', 'type' => 'text', 'max' => 180],
                'brand' => ['label' => 'Brand line', 'type' => 'text', 'max' => 160],
                'tagline' => ['label' => 'Tagline', 'type' => 'text', 'max' => 220],
                'links' => [
                    'label' => 'Social links',
                    'type' => 'repeater',
                    'max_items' => 8,
                    'fields' => [
                        'label' => ['label' => 'Label', 'type' => 'text', 'max' => 80],
                        'url' => ['label' => 'URL', 'type' => 'link', 'max' => 2048],
                    ],
                ],
                'copyright_name' => ['label' => 'Copyright name', 'type' => 'text', 'max' => 160],
                'role_line' => ['label' => 'Role line', 'type' => 'text', 'max' => 240],
            ],
            'content' => [
                'background_image' => 'images/research/anmol-goel-research-portrait.jpg',
                'background_alt' => 'Anmol Pushjai Goel research portrait',
                'brand' => 'Anmol Pushjai Goel',
                'tagline' => 'Research · essays · recommended reading',
                'links' => [
                    ['_key' => 'link-1', 'label' => 'Substack', 'url' => '#'],
                    ['_key' => 'link-2', 'label' => 'Twitter / X', 'url' => '#'],
                    ['_key' => 'link-3', 'label' => 'LinkedIn', 'url' => '#'],
                ],
                'copyright_name' => 'Anmol Pushjai Goel',
                'role_line' => 'Founder & CEO, Nuclear Edge · Trustee, Bharat Governance Council',
            ],
        ],
    ],

    'categories' => [
        ['name' => 'Articles', 'slug' => 'article', 'label' => 'Articles', 'sort_order' => 10],
        ['name' => 'Essays', 'slug' => 'essay', 'label' => 'Essays', 'sort_order' => 20],
        ['name' => 'Recommended Studies', 'slug' => 'study', 'label' => 'Recommended Studies', 'sort_order' => 30],
        ['name' => 'Research', 'slug' => 'research', 'label' => 'Research', 'sort_order' => 40],
    ],

    'publications' => [
        ['category' => 'article', 'title' => 'We Are Not Behind in the AI Race', 'venue' => 'Financial Express', 'year' => 2026, 'status' => 'Published', 'summary' => 'India is not losing the AI race; it is running a different one. Success is measured by deployment across governance, health and education — not the count of frontier models.', 'tags' => ['AI policy', 'India', 'deployment'], 'url' => null],
        ['category' => 'article', 'title' => 'Rule-Maker, Not Rule-Taker', 'venue' => 'Op-ed', 'year' => 2025, 'status' => 'Published', 'summary' => 'Why India must help write the global rules of AI rather than inherit them — and what an aggressive, accountable industry posture looks like in practice.', 'tags' => ['regulation', 'sovereignty'], 'url' => null],
        ['category' => 'article', 'title' => 'Reading a Billion Consumers', 'venue' => 'Essay / Trade press', 'year' => 2025, 'status' => 'Published', 'summary' => 'India is not one market. Behaviour fractures across language, income and digital-access tiers — and most strategy fails because it averages them away.', 'tags' => ['consumer behaviour', 'markets'], 'url' => null],
        ['category' => 'essay', 'title' => 'A Real Book Should Hurt', 'venue' => 'On reading', 'year' => 2025, 'status' => 'Essay', 'summary' => 'A manifesto against comfortable reading: read less, read slower, read what makes you sick — and let a book break the dumbest thing you believe.', 'tags' => ['reading', 'epistemics'], 'url' => '/books#top'],
        ['category' => 'essay', 'title' => 'Achieved Worth over Inherited Worth', 'venue' => 'On education & dignity', 'year' => 2025, 'status' => 'Essay', 'summary' => 'The most valuable thing a person can own is not what they inherit but what they build — and education is the one lever that changes a position rather than relieving it.', 'tags' => ['education', 'caste', 'dignity'], 'url' => '/philanthropy#top'],
        ['category' => 'essay', 'title' => 'Systems over Slogans', 'venue' => 'On governance', 'year' => 2026, 'status' => 'Essay', 'summary' => 'Real change arrives when positions change — when the overlooked gain leverage and institutions behave differently, not when a campaign trends and evaporates.', 'tags' => ['governance', 'institutions'], 'url' => null],
        ['category' => 'study', 'title' => 'The Weirdest People in the World?', 'venue' => 'Henrich, Heine & Norenzayan · Behavioral and Brain Sciences', 'year' => 2010, 'status' => 'Recommended', 'summary' => 'The behavioural sciences over-generalise from Western, Educated, Industrialised, Rich, Democratic samples — a warning that travels straight into how we read India.', 'tags' => ['psychology', 'WEIRD', 'method'], 'url' => null],
        ['category' => 'study', 'title' => 'The Colonial Origins of Comparative Development', 'venue' => 'Acemoglu, Johnson & Robinson · American Economic Review', 'year' => 2001, 'status' => 'Recommended', 'summary' => "Institutions, not geography or culture, explain why nations diverge — the empirical backbone behind 'why nations fail.'", 'tags' => ['institutions', 'development'], 'url' => null],
        ['category' => 'study', 'title' => 'Prospect Theory: Decision under Risk', 'venue' => 'Kahneman & Tversky · Econometrica', 'year' => 1979, 'status' => 'Recommended', 'summary' => 'People are not the rational agents economics assumed — losses loom larger than gains, and that asymmetry rewires every model of choice.', 'tags' => ['behavioural econ', 'risk'], 'url' => null],
        ['category' => 'study', 'title' => 'The Strength of Weak Ties', 'venue' => 'Granovetter · American Journal of Sociology', 'year' => 1973, 'status' => 'Recommended', 'summary' => 'Information, jobs and influence travel through acquaintances, not close friends — the small idea that founded modern network sociology.', 'tags' => ['networks', 'sociology'], 'url' => null],
        ['category' => 'research', 'title' => "Deployment over Frontier: A Framework for India's AI Adoption", 'venue' => 'Working paper · Nuclear Edge', 'year' => 2026, 'status' => 'Working paper', 'summary' => 'A measurement framework that scores AI progress by integration into public-service delivery and productivity, not by model scale.', 'tags' => ['AI', 'framework', 'India'], 'url' => null],
        ['category' => 'research', 'title' => "Consumer Heterogeneity Across India's Digital Tiers", 'venue' => 'Working paper', 'year' => 2025, 'status' => 'Working paper', 'summary' => 'A segmentation model of Indian consumers along digital-literacy and access gradients, with implications for product and policy design.', 'tags' => ['consumer', 'segmentation'], 'url' => null],
        ['category' => 'research', 'title' => 'Adaptive Governance for Automation', 'venue' => 'Bharat Governance Council', 'year' => 2026, 'status' => 'In progress', 'summary' => 'Designing governance frameworks that update as fast as the technologies they regulate — responsive institutions over static rulebooks.', 'tags' => ['governance', 'automation'], 'url' => null],
    ],
];
