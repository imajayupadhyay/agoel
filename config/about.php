<?php

return [
    'page' => [
        'title' => 'About Anmol Goel',
        'seo_title' => 'About — Anmol Pushjai Goel',
        'meta_description' => 'About Anmol Pushjai Goel — Founder & CEO of Nuclear Edge, Trustee of the Bharat Governance Council, and a leading Indian voice on AI policy, technology and society.',
        'og_image' => 'images/about/anmol-pushjai-goel-portrait-hero.jpg',
    ],

    'sections' => [
        'hero' => [
            'name' => 'Recognition Hero',
            'type' => 'hero',
            'sort_order' => 10,
            'fields' => [
                'eyebrow' => ['label' => 'Eyebrow', 'type' => 'text', 'max' => 120],
                'heading_line_one' => ['label' => 'Heading line one', 'type' => 'text', 'max' => 120],
                'heading_line_two' => ['label' => 'Heading line two', 'type' => 'text', 'max' => 120],
                'lede' => ['label' => 'Intro paragraph', 'type' => 'textarea', 'max' => 700],
                'scrollcue' => ['label' => 'Scroll cue', 'type' => 'text', 'max' => 120],
                'background_image' => ['label' => 'Primary portrait background', 'type' => 'image'],
                'secondary_background_image' => ['label' => 'Secondary portrait background', 'type' => 'image'],
                'roles' => [
                    'label' => 'Role chips',
                    'type' => 'repeater',
                    'max_items' => 12,
                    'fields' => [
                        'label' => ['label' => 'Label', 'type' => 'text', 'max' => 80],
                    ],
                ],
                'recognitions' => [
                    'label' => 'Recognition wall',
                    'type' => 'repeater',
                    'max_items' => 40,
                    'fields' => [
                        'category' => ['label' => 'Category', 'type' => 'text', 'max' => 80],
                        'name' => ['label' => 'Name', 'type' => 'text', 'max' => 160],
                        'title' => ['label' => 'Title / role', 'type' => 'textarea', 'max' => 320],
                        'quote' => ['label' => 'Optional quote', 'type' => 'textarea', 'max' => 800],
                    ],
                ],
            ],
            'content' => [
                'eyebrow' => 'Recognized by',
                'heading_line_one' => 'A reputation',
                'heading_line_two' => 'built on edge.',
                'lede' => "Among the senior bureaucrats, leading academics and seasoned entrepreneurs who know Anmol's work — and his blend of a sharp, aggressive style with real academic depth.",
                'scrollcue' => 'About Anmol',
                'background_image' => 'images/about/anmol-pushjai-goel-portrait-hero.jpg',
                'secondary_background_image' => 'images/about/anmol-pushjai-goel-portrait-secondary.jpg',
                'roles' => [
                    ['_key' => 'bureaucrats', 'label' => 'Bureaucrats'],
                    ['_key' => 'academics', 'label' => 'Academics'],
                    ['_key' => 'entrepreneurs', 'label' => 'Entrepreneurs'],
                ],
                'recognitions' => [
                    ['_key' => 'kush-verma', 'category' => 'Bureaucrat', 'name' => 'Kush Verma, IAS', 'title' => 'Former Principal Secretary, Govt. of UP · Director, LBSNAA · Author', 'quote' => ''],
                    ['_key' => 'manoj-bharti', 'category' => 'Bureaucrat', 'name' => 'Manoj K. Bharti', 'title' => 'Indian Foreign Service · 1984 batch', 'quote' => ''],
                    ['_key' => 'sanjay-kumar', 'category' => 'Bureaucrat', 'name' => 'Sanjay Kumar', 'title' => 'Director General, Forests (India) · Climate Parliament Advisor, UN', 'quote' => ''],
                    ['_key' => 'gopal-singh', 'category' => 'Bureaucrat', 'name' => 'Gopal Singh, IAS', 'title' => 'CMD, Coal India', 'quote' => ''],
                    ['_key' => 'ashok-kumar', 'category' => 'Bureaucrat', 'name' => 'Ashok Kumar, IPS', 'title' => 'Indian Police Service · 1984 batch', 'quote' => ''],
                    ['_key' => 'ajay-kumar-chauhan', 'category' => 'Bureaucrat', 'name' => 'Ajay Kumar Chauhan, IRS', 'title' => 'Principal Commissioner, GST · 1984 batch', 'quote' => ''],
                    ['_key' => 'kp-shashidharan', 'category' => 'Bureaucrat', 'name' => 'K. P. Shashidharan', 'title' => 'Former Director General of Audit (Central) · Indian Audit & Accounts Service (IA&AS)', 'quote' => ''],
                    ['_key' => 'vivek-kumar', 'category' => 'Academic', 'name' => 'Prof. Vivek Kumar', 'title' => 'Sociologist & public intellectual · Chairperson, School of Social Sciences, JNU', 'quote' => ''],
                    ['_key' => 'yogendra-yadav', 'category' => 'Academic', 'name' => 'Yogendra Yadav', 'title' => 'Psephologist & social observer', 'quote' => ''],
                    ['_key' => 'romila-thapar', 'category' => 'Academic', 'name' => 'Romila Thapar', 'title' => 'Historian', 'quote' => ''],
                    ['_key' => 'kanwal-rekhi', 'category' => 'Entrepreneur', 'name' => 'Kanwal Rekhi', 'title' => 'Venture capitalist & angel investor', 'quote' => ''],
                    ['_key' => 'robert-croci', 'category' => 'Entrepreneur', 'name' => 'Robert Croci', 'title' => 'Director, Public Investment Fund (UAE)', 'quote' => ''],
                ],
            ],
        ],
        'profile' => [
            'name' => 'About Profile',
            'type' => 'profile',
            'sort_order' => 20,
            'fields' => [
                'eyebrow' => ['label' => 'Eyebrow', 'type' => 'text', 'max' => 120],
                'heading_line_one' => ['label' => 'Heading line one', 'type' => 'text', 'max' => 120],
                'heading_line_two' => ['label' => 'Heading line two', 'type' => 'text', 'max' => 120],
                'signature' => ['label' => 'Signature', 'type' => 'text', 'max' => 120],
                'metadata' => [
                    'label' => 'Profile facts',
                    'type' => 'repeater',
                    'max_items' => 16,
                    'fields' => [
                        'label' => ['label' => 'Label', 'type' => 'text', 'max' => 80],
                        'value' => ['label' => 'Value', 'type' => 'text', 'max' => 180],
                    ],
                ],
                'paragraphs' => [
                    'label' => 'Profile paragraphs',
                    'type' => 'repeater',
                    'max_items' => 8,
                    'fields' => [
                        'before' => ['label' => 'Text before emphasis', 'type' => 'textarea', 'max' => 700],
                        'emphasis' => ['label' => 'Emphasized text', 'type' => 'text', 'max' => 240],
                        'after' => ['label' => 'Text after emphasis', 'type' => 'textarea', 'max' => 700],
                    ],
                ],
            ],
            'content' => [
                'eyebrow' => 'The Person',
                'heading_line_one' => 'About Anmol',
                'heading_line_two' => 'Pushjai Goel.',
                'signature' => 'Anmol Pushjai Goel',
                'metadata' => [
                    ['_key' => 'company', 'label' => 'Company', 'value' => 'Founder & CEO, Nuclear Edge'],
                    ['_key' => 'governance', 'label' => 'Governance', 'value' => 'Trustee, Bharat Governance Council'],
                    ['_key' => 'advisory', 'label' => 'Advisory', 'value' => 'Union Govt. of India'],
                    ['_key' => 'training', 'label' => 'Training', 'value' => 'Psychology · Philosophy · Sociology'],
                ],
                'paragraphs' => [
                    [
                        '_key' => 'entrepreneur',
                        'before' => 'An ',
                        'emphasis' => 'entrepreneur, tech-policy voice and industrialist',
                        'after' => ' — Anmol Pushjai Goel leads Nuclear Edge, a deep-technology and consulting firm, and sits as a Trustee of the Bharat Governance Council with advisory roles across the Union Government of India.',
                    ],
                    [
                        '_key' => 'training',
                        'before' => 'What sets him apart is the training behind the work. Not engineering, but ',
                        'emphasis' => 'psychology, philosophy and sociology',
                        'after' => ' — across Panjab University and JNU — a lens he turns on technology adoption, institutions, and the social weight of AI in India.',
                    ],
                    [
                        '_key' => 'posture',
                        'before' => 'The result is a single posture across the company, the policy work and the writing: ',
                        'emphasis' => 'aggressive without being reckless, ambitious but grounded',
                        'after' => " in India's structural realities — and unsparing where celebratory narratives replace honest reckoning.",
                    ],
                ],
            ],
        ],
        'voice' => [
            'name' => 'In His Words',
            'type' => 'voice',
            'sort_order' => 30,
            'fields' => [
                'eyebrow' => ['label' => 'Eyebrow', 'type' => 'text', 'max' => 120],
                'byline' => ['label' => 'Byline', 'type' => 'text', 'max' => 120],
                'quotes' => [
                    'label' => 'Rotating quotes',
                    'type' => 'repeater',
                    'max_items' => 20,
                    'fields' => [
                        'text' => ['label' => 'Quote text', 'type' => 'textarea', 'max' => 700],
                    ],
                ],
            ],
            'content' => [
                'eyebrow' => 'In his words',
                'byline' => 'Anmol Pushjai Goel',
                'quotes' => [
                    ['_key' => 'motion', 'text' => 'Motion is not movement. You can sprint in a circle your whole life. Pick the direction before you pick up the speed.'],
                    ['_key' => 'confidence', 'text' => 'Inherited ego is sealed shut. Earned confidence updates like software — it takes a hit and learns. Be the upgradeable one.'],
                    ['_key' => 'monopoly', 'text' => 'Everyone ‘differentiates.’ Differentiation is two restaurants arguing over the menu. Monopoly is being the only door in town.'],
                    ['_key' => 'moat', 'text' => 'Being first is worthless if leaving you is easy. The moat was never the head start — it was the exit you welded shut.'],
                    ['_key' => 'vision', 'text' => 'No one wants your vision. They want to know if it makes money. Sell something first, then they’ll listen to your philosophy.'],
                    ['_key' => 'tam', 'text' => 'The TAM slide is fiction you wrote for a man who knows it’s fiction — and is checking whether you know too.'],
                ],
            ],
        ],
        'footer' => [
            'name' => 'About Footer',
            'type' => 'footer',
            'sort_order' => 40,
            'fields' => [
                'eyebrow' => ['label' => 'Eyebrow', 'type' => 'text', 'max' => 120],
                'email' => ['label' => 'Email', 'type' => 'email', 'max' => 254],
                'back_label' => ['label' => 'Back to top label', 'type' => 'text', 'max' => 80],
                'copyright_name' => ['label' => 'Copyright line', 'type' => 'text', 'max' => 180],
                'role_line' => ['label' => 'Footer role line', 'type' => 'text', 'max' => 240],
                'socials' => [
                    'label' => 'Social links',
                    'type' => 'repeater',
                    'max_items' => 8,
                    'fields' => [
                        'label' => ['label' => 'Label', 'type' => 'text', 'max' => 80],
                        'url' => ['label' => 'URL', 'type' => 'link', 'max' => 2048],
                    ],
                ],
            ],
            'content' => [
                'eyebrow' => 'Get in touch',
                'email' => 'hello@anmolpushjaigoel.com',
                'back_label' => 'Back to top',
                'copyright_name' => 'Anmol Pushjai Goel. All rights reserved.',
                'role_line' => 'Entrepreneur · Tech & AI Policy Voice · Author',
                'socials' => [
                    ['_key' => 'linkedin', 'label' => 'LinkedIn', 'url' => '#'],
                    ['_key' => 'twitter', 'label' => 'X / Twitter', 'url' => '#'],
                    ['_key' => 'instagram', 'label' => 'Instagram', 'url' => '#'],
                ],
            ],
        ],
    ],
];
