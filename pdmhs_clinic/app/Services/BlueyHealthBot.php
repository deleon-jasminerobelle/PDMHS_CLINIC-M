<?php

namespace App\Services;

class BlueyHealthBot
{
    private $knowledgeBase;

    public function __construct()
    {
        $this->knowledgeBase = $this->loadKnowledgeBase();
    }

    /**
     * Process user question and return Bluey's response
     */
    public function ask(string $question): array
    {
        $question = strtolower(trim($question));
        
        // Find best match
        $response = $this->findBestMatch($question);
        
        return [
            'question' => $question,
            'answer' => $response['answer'],
            'category' => $response['category'],
            'confidence' => $response['confidence'],
            'related_topics' => $response['related'] ?? []
        ];
    }

    /**
     * Find best matching answer from knowledge base
     */
    private function findBestMatch(string $question): array
    {
        $bestMatch = null;
        $highestScore = 0;

        foreach ($this->knowledgeBase as $category => $items) {
            foreach ($items as $item) {
                $score = $this->calculateMatchScore($question, $item['keywords']);
                
                if ($score > $highestScore) {
                    $highestScore = $score;
                    $bestMatch = [
                        'answer' => $item['answer'],
                        'category' => $category,
                        'confidence' => $score,
                        'related' => $item['related'] ?? []
                    ];
                }
            }
        }

        if ($highestScore < 0.1) {
            return [
                'answer' => "Hi! I'm Bluey, your health buddy! 💙 I didn't quite understand your question. Could you try asking about common health topics like headaches, fever, first aid, nutrition, stress, or hygiene?",
                'category' => 'general',
                'confidence' => 0,
                'related' => ['What causes headaches?', 'How to treat fever?', 'Basic first aid tips']
            ];
        }

        return $bestMatch;
    }

    /**
     * Calculate match score between question and keywords
     */
    private function calculateMatchScore(string $question, array $keywords): float
    {
        $matches = 0;
        $totalKeywords = count($keywords);

        foreach ($keywords as $keyword) {
            if (str_contains($question, strtolower($keyword))) {
                $matches++;
            }
        }

        // Return score based on at least one match
        return $matches > 0 ? ($matches / $totalKeywords) : 0;
    }

    /**
     * Load health knowledge base
     */
    private function loadKnowledgeBase(): array
    {
        return [
            'common_health' => [
                [
                    'keywords' => ['headache', 'head', 'pain', 'ulo', 'masakit'],
                    'answer' => "💙 **Headache Relief Tips:**\n\n1. Rest in a quiet, dark room\n2. Drink plenty of water (dehydration can cause headaches)\n3. Apply a cold compress to your forehead\n4. Take prescribed pain reliever if needed\n5. Avoid screens and bright lights\n\n⚠️ Visit the clinic if:\n- Severe or sudden headache\n- Accompanied by fever, stiff neck, or confusion\n- Headache after head injury",
                    'related' => ['What causes headaches?', 'Migraine vs regular headache', 'Dehydration symptoms']
                ],
                [
                    'keywords' => ['fever', 'lagnat', 'hot', 'mainit', 'temperature'],
                    'answer' => "🌡️ **Fever Management:**\n\n1. Rest and stay hydrated\n2. Take paracetamol as directed\n3. Use lukewarm water for sponge bath (not cold!)\n4. Wear light, comfortable clothing\n5. Monitor temperature regularly\n\n⚠️ Seek immediate help if:\n- Temperature above 39°C (102°F)\n- Fever lasts more than 3 days\n- Accompanied by rash, difficulty breathing, or severe pain\n- Infant under 3 months with any fever",
                    'related' => ['How to take temperature correctly', 'When is fever dangerous?', 'Fever vs heat stroke']
                ],
                [
                    'keywords' => ['cough', 'ubo', 'throat', 'lalamunan'],
                    'answer' => "😷 **Cough & Throat Care:**\n\n1. Drink warm water with honey (if over 1 year old)\n2. Gargle with warm salt water\n3. Stay hydrated\n4. Use humidifier or steam inhalation\n5. Avoid cold drinks and ice cream\n\n⚠️ Visit clinic if:\n- Cough lasts more than 2 weeks\n- Coughing up blood\n- Difficulty breathing\n- High fever with cough",
                    'related' => ['Dry cough vs wet cough', 'Sore throat remedies', 'COVID-19 symptoms']
                ],
                [
                    'keywords' => ['stomach', 'tiyan', 'diarrhea', 'vomit', 'suka', 'pagtatae'],
                    'answer' => "🤢 **Stomach Problems:**\n\n1. Stay hydrated with ORS (oral rehydration solution)\n2. Eat bland foods (rice, banana, toast)\n3. Avoid dairy, spicy, and fatty foods\n4. Rest your stomach\n5. Small, frequent meals\n\n⚠️ Seek help if:\n- Severe dehydration (dry mouth, no tears, dark urine)\n- Blood in stool or vomit\n- Severe abdominal pain\n- Symptoms last more than 2 days",
                    'related' => ['Food poisoning signs', 'How to make ORS at home', 'Appendicitis symptoms']
                ]
            ],
            'first_aid' => [
                [
                    'keywords' => ['first aid', 'basic', 'emergency', 'tips', 'first', 'aid'],
                    'answer' => "🩹 **Basic First Aid Tips:**\n\n**For Cuts & Wounds:**\n- Stop bleeding with pressure\n- Clean with water\n- Apply antiseptic\n- Cover with bandage\n\n**For Burns:**\n- Cool with running water (10-20 min)\n- Don't use ice or butter\n- Cover with clean cloth\n\n**For Sprains:**\n- Rest, Ice, Compression, Elevation (RICE)\n- Apply ice for 15-20 minutes\n\n**For Nosebleeds:**\n- Sit up, lean forward\n- Pinch nose for 10 minutes\n\n**When to Get Help:**\n- Heavy bleeding\n- Severe pain\n- Difficulty breathing\n- Loss of consciousness\n\n💙 Always seek professional help for serious injuries!",
                    'related' => ['Cuts treatment', 'Burns treatment', 'Sprains care', 'Emergency numbers']
                ],
                [
                    'keywords' => ['cut', 'wound', 'sugat', 'bleeding', 'dugo'],
                    'answer' => "🩹 **Wound Care:**\n\n1. **Stop bleeding:** Apply direct pressure with clean cloth\n2. **Clean:** Rinse with clean water (avoid alcohol on open wounds)\n3. **Disinfect:** Apply antiseptic around wound\n4. **Cover:** Use sterile bandage\n5. **Monitor:** Watch for signs of infection\n\n⚠️ Go to clinic if:\n- Deep or gaping wound\n- Won't stop bleeding after 10 minutes\n- Caused by dirty or rusty object\n- Signs of infection (redness, swelling, pus)",
                    'related' => ['When do you need stitches?', 'Tetanus shot needed?', 'Infection signs']
                ],
                [
                    'keywords' => ['burn', 'paso', 'hot', 'fire', 'apoy'],
                    'answer' => "🔥 **Burn Treatment:**\n\n1. **Cool immediately:** Run cool (not ice cold) water for 10-20 minutes\n2. **Remove:** Take off jewelry/tight clothing near burn\n3. **Cover:** Use clean, dry cloth\n4. **Don't:** Pop blisters, apply ice, butter, or toothpaste\n5. **Pain relief:** Take paracetamol if needed\n\n⚠️ Seek medical help if:\n- Larger than your palm\n- On face, hands, feet, or genitals\n- Blistering or charred skin\n- Chemical or electrical burn",
                    'related' => ['Burn degrees explained', 'Sunburn treatment', 'Chemical burn first aid']
                ],
                [
                    'keywords' => ['sprain', 'pilay', 'ankle', 'wrist', 'twist'],
                    'answer' => "🦵 **Sprain Care (RICE Method):**\n\n**R**est - Stop activity immediately\n**I**ce - Apply ice pack for 15-20 minutes every 2-3 hours\n**C**ompression - Wrap with elastic bandage (not too tight)\n**E**levation - Keep injured area raised above heart level\n\n⚠️ Visit clinic if:\n- Unable to bear weight\n- Severe swelling or bruising\n- Numbness or tingling\n- No improvement after 48 hours",
                    'related' => ['Sprain vs fracture', 'How to wrap ankle', 'When to use crutches']
                ],
                [
                    'keywords' => ['nosebleed', 'nose', 'blood', 'ilong', 'balungos'],
                    'answer' => "👃 **Nosebleed First Aid:**\n\n1. **Sit up straight** and lean slightly forward\n2. **Pinch** soft part of nose for 10 minutes\n3. **Breathe** through your mouth\n4. **Don't:** Tilt head back or lie down\n5. **After:** Avoid blowing nose for several hours\n\n⚠️ Get help if:\n- Bleeding doesn't stop after 20 minutes\n- Heavy bleeding\n- After head injury\n- Frequent nosebleeds",
                    'related' => ['What causes nosebleeds?', 'Preventing nosebleeds', 'When is it serious?']
                ]
            ],
            'medical_terms' => [
                [
                    'keywords' => ['hypertension', 'high blood', 'blood pressure', 'bp'],
                    'answer' => "📊 **Hypertension (High Blood Pressure)**\n\nA condition where blood pressure is consistently too high (140/90 mmHg or higher).\n\n**Symptoms:** Often no symptoms (\"silent killer\")\n**Risks:** Heart disease, stroke, kidney problems\n**Prevention:**\n- Reduce salt intake\n- Exercise regularly\n- Maintain healthy weight\n- Manage stress\n- Avoid smoking",
                    'related' => ['Normal blood pressure range', 'How to measure BP', 'Hypertension diet']
                ],
                [
                    'keywords' => ['diabetes', 'sugar', 'glucose', 'insulin'],
                    'answer' => "🍬 **Diabetes**\n\nA condition where blood sugar levels are too high.\n\n**Types:**\n- Type 1: Body doesn't produce insulin\n- Type 2: Body doesn't use insulin properly\n\n**Symptoms:**\n- Frequent urination\n- Excessive thirst\n- Unexplained weight loss\n- Fatigue\n- Blurred vision\n\n**Management:** Diet, exercise, medication, blood sugar monitoring",
                    'related' => ['Pre-diabetes', 'Blood sugar levels', 'Diabetic diet']
                ],
                [
                    'keywords' => ['asthma', 'hika', 'breathing', 'inhaler'],
                    'answer' => "🫁 **Asthma**\n\nA chronic condition affecting airways in the lungs.\n\n**Symptoms:**\n- Wheezing\n- Shortness of breath\n- Chest tightness\n- Coughing (especially at night)\n\n**Triggers:**\n- Allergens (dust, pollen)\n- Exercise\n- Cold air\n- Stress\n- Smoke\n\n**Management:** Avoid triggers, use prescribed inhalers, action plan",
                    'related' => ['How to use inhaler', 'Asthma attack what to do', 'Asthma vs COPD']
                ],
                [
                    'keywords' => ['anemia', 'iron', 'hemoglobin', 'blood'],
                    'answer' => "🩸 **Anemia**\n\nA condition where you lack enough healthy red blood cells.\n\n**Symptoms:**\n- Fatigue and weakness\n- Pale skin\n- Dizziness\n- Cold hands and feet\n- Shortness of breath\n\n**Common Causes:**\n- Iron deficiency\n- Vitamin B12 deficiency\n- Blood loss\n\n**Treatment:** Iron supplements, diet rich in iron (meat, beans, leafy greens)",
                    'related' => ['Iron-rich foods', 'Vitamin B12 sources', 'Anemia types']
                ]
            ],
            'hygiene' => [
                [
                    'keywords' => ['handwashing', 'wash hands', 'hugas', 'kamay'],
                    'answer' => "🧼 **Proper Handwashing:**\n\n1. Wet hands with clean water\n2. Apply soap\n3. Lather for at least 20 seconds (sing Happy Birthday twice!)\n4. Scrub all surfaces: palms, backs, between fingers, under nails\n5. Rinse thoroughly\n6. Dry with clean towel\n\n**When to wash:**\n- Before eating\n- After using bathroom\n- After coughing/sneezing\n- After touching animals\n- Before and after treating wounds",
                    'related' => ['Hand sanitizer vs soap', 'Proper handwashing technique', 'Why 20 seconds?']
                ],
                [
                    'keywords' => ['dental', 'teeth', 'ngipin', 'toothbrush'],
                    'answer' => "🦷 **Dental Hygiene:**\n\n**Daily Care:**\n- Brush twice daily (2 minutes each)\n- Use fluoride toothpaste\n- Floss once daily\n- Rinse with mouthwash\n- Replace toothbrush every 3 months\n\n**Healthy Habits:**\n- Limit sugary foods and drinks\n- Drink plenty of water\n- Visit dentist every 6 months\n- Don't use teeth as tools\n\n**Warning Signs:** Bleeding gums, persistent bad breath, tooth pain",
                    'related' => ['Cavity prevention', 'Proper brushing technique', 'Wisdom teeth']
                ]
            ],
            'mental_health' => [
                [
                    'keywords' => ['stress', 'anxiety', 'worried', 'nervous', 'kabado', 'takot'],
                    'answer' => "🧠 **Managing Stress & Anxiety:**\n\n**Quick Relief:**\n- Deep breathing (4-7-8 technique)\n- Take a short walk\n- Talk to someone you trust\n- Listen to calming music\n- Progressive muscle relaxation\n\n**Long-term:**\n- Regular exercise\n- Adequate sleep (7-9 hours)\n- Healthy diet\n- Time management\n- Hobbies and relaxation\n\n💙 Remember: It's okay to ask for help. Talk to school counselor or clinic staff.",
                    'related' => ['Breathing exercises', 'Signs of anxiety disorder', 'When to seek help']
                ],
                [
                    'keywords' => ['sleep', 'insomnia', 'tulog', 'hindi makatulog'],
                    'answer' => "😴 **Better Sleep Tips:**\n\n**Sleep Hygiene:**\n- Consistent sleep schedule\n- 7-9 hours for teens\n- Dark, quiet, cool room\n- No screens 1 hour before bed\n- Avoid caffeine after 2 PM\n\n**Bedtime Routine:**\n- Relaxing activities (reading, music)\n- Warm bath\n- Light stretching\n- Avoid heavy meals\n\n⚠️ Persistent sleep problems? Talk to clinic staff.",
                    'related' => ['Sleep cycle explained', 'Effects of sleep deprivation', 'Power naps']
                ],
                [
                    'keywords' => ['sad', 'depressed', 'malungkot', 'down', 'lonely'],
                    'answer' => "💙 **Feeling Down? You're Not Alone:**\n\n**Immediate Help:**\n- Talk to someone you trust\n- Write down your feelings\n- Do something you enjoy\n- Get some sunlight\n- Physical activity helps\n\n**Remember:**\n- Your feelings are valid\n- It's okay to not be okay\n- Asking for help is strength, not weakness\n- Things can and will get better\n\n🆘 **Need Support?**\n- School counselor\n- Clinic staff\n- Trusted teacher or family member\n- Mental health hotline: 0917-899-USAP (8727)\n\n⚠️ If you're having thoughts of self-harm, please seek help immediately.",
                    'related' => ['Depression signs', 'How to help a friend', 'Mental health resources']
                ],
                [
                    'keywords' => ['exam', 'test', 'pressure', 'academic', 'grades', 'pagsusulit'],
                    'answer' => "📚 **Academic Stress Management:**\n\n**Study Smart:**\n- Break study time into chunks (25-min sessions)\n- Take regular breaks\n- Study in a quiet, comfortable space\n- Use active learning techniques\n- Form study groups\n\n**Before Exams:**\n- Get enough sleep (don't cram all night!)\n- Eat a healthy breakfast\n- Arrive early to settle in\n- Deep breathing if nervous\n- Positive self-talk\n\n**Remember:**\n- One test doesn't define you\n- Do your best, that's enough\n- Learn from mistakes\n- Balance is important\n\n💙 Your mental health matters more than grades!",
                    'related' => ['Study techniques', 'Test anxiety tips', 'Time management']
                ],
                [
                    'keywords' => ['bullying', 'bully', 'harassment', 'api', 'inaapi'],
                    'answer' => "🛡️ **Dealing with Bullying:**\n\n**If You're Being Bullied:**\n- Tell a trusted adult immediately\n- Don't respond with violence\n- Stay with friends/groups\n- Document incidents (dates, what happened)\n- It's NOT your fault\n\n**Report To:**\n- School counselor\n- Teacher or adviser\n- Clinic staff\n- Parents/guardians\n- School administration\n\n**If You See Bullying:**\n- Don't join in\n- Support the victim\n- Report to adults\n- Be an upstander, not a bystander\n\n💙 Everyone deserves to feel safe at school. Speak up!",
                    'related' => ['Cyberbullying', 'Building confidence', 'Support resources']
                ],
                [
                    'keywords' => ['confidence', 'self-esteem', 'kumpiyansa', 'worth'],
                    'answer' => "✨ **Building Self-Confidence:**\n\n**Daily Practices:**\n- Positive affirmations\n- Celebrate small wins\n- Focus on strengths\n- Set achievable goals\n- Practice self-compassion\n\n**Remember:**\n- You are unique and valuable\n- Compare yourself to yesterday's you, not others\n- Mistakes are learning opportunities\n- Your worth isn't based on others' opinions\n- Progress over perfection\n\n**Boost Your Confidence:**\n- Try new things\n- Help others\n- Take care of your appearance\n- Develop a skill or hobby\n- Surround yourself with positive people\n\n💙 You are enough, just as you are!",
                    'related' => ['Positive thinking', 'Goal setting', 'Self-care tips']
                ]
            ],
            'nutrition' => [
                [
                    'keywords' => ['nutrition', 'diet', 'healthy eating', 'pagkain', 'food', 'tips', 'eating tips'],
                    'answer' => "🥗 **Healthy Eating for Students:**\n\n**Balanced Plate:**\n- 50% vegetables and fruits\n- 25% whole grains (brown rice, wheat bread)\n- 25% protein (fish, chicken, beans, eggs)\n- Healthy fats (nuts, avocado)\n\n**Daily Essentials:**\n- 3 main meals + 2 healthy snacks\n- 8-10 glasses of water\n- Variety of colorful foods\n- Limit processed foods\n- Reduce sugar and salt\n\n**Benefits:**\n- Better concentration\n- More energy\n- Stronger immune system\n- Better mood\n- Healthy growth\n\n💙 Good nutrition = Better learning!",
                    'related' => ['Healthy snacks', 'Meal planning', 'Food groups']
                ],
                [
                    'keywords' => ['breakfast', 'almusal', 'morning meal'],
                    'answer' => "🍳 **Importance of Breakfast:**\n\n**Why Breakfast Matters:**\n- Boosts brain power and concentration\n- Provides energy for the day\n- Improves academic performance\n- Better mood and behavior\n- Helps maintain healthy weight\n\n**Quick Healthy Options:**\n- Oatmeal with fruits\n- Whole wheat bread with peanut butter\n- Banana and milk\n- Boiled egg and rice\n- Yogurt with granola\n\n**Tips:**\n- Eat within 2 hours of waking\n- Include protein and fiber\n- Prepare night before if rushed\n- Keep it simple\n\n⚠️ Never skip breakfast before exams!",
                    'related' => ['Quick breakfast ideas', 'Meal prep tips', 'Energy foods']
                ],
                [
                    'keywords' => ['snack', 'merienda', 'hungry', 'gutom'],
                    'answer' => "🍎 **Healthy Snack Ideas:**\n\n**Smart Snacks:**\n- Fresh fruits (banana, apple, orange)\n- Nuts and seeds (peanuts, cashews)\n- Yogurt\n- Whole grain crackers\n- Boiled eggs\n- Vegetable sticks with dip\n- Cheese\n- Trail mix\n\n**Avoid:**\n- Chips and junk food\n- Sugary drinks\n- Candy and sweets\n- Instant noodles\n- Deep fried foods\n\n**Snacking Tips:**\n- Eat when truly hungry\n- Control portions\n- Snack 2-3 hours before meals\n- Stay hydrated\n\n💙 Healthy snacks = Sustained energy!",
                    'related' => ['Portion control', 'Reading food labels', 'Meal timing']
                ],
                [
                    'keywords' => ['water', 'hydration', 'tubig', 'thirsty', 'uhaw', 'dehydration', 'dehydrated', 'symptoms'],
                    'answer' => "💧 **Stay Hydrated!**\n\n**Why Water is Important:**\n- Regulates body temperature\n- Helps concentration and memory\n- Prevents headaches\n- Improves skin health\n- Aids digestion\n- Boosts energy\n\n**How Much:**\n- Students: 8-10 glasses daily\n- More if exercising or hot weather\n- Drink before feeling thirsty\n\n**Tips:**\n- Bring water bottle to school\n- Drink water with meals\n- Add lemon for flavor\n- Set reminders\n- Track your intake\n\n**Signs of Dehydration:**\n- Dark yellow urine\n- Dry mouth\n- Headache\n- Fatigue\n- Dizziness\n\n💙 Water is the best drink!",
                    'related' => ['Dehydration symptoms', 'Sports drinks vs water', 'Healthy beverages']
                ],
                [
                    'keywords' => ['vitamins', 'supplements', 'bitamina', 'nutrients'],
                    'answer' => "💊 **Vitamins & Nutrients for Students:**\n\n**Essential Nutrients:**\n\n**Vitamin A** (Vision, Immunity)\n- Carrots, sweet potato, malunggay\n\n**Vitamin C** (Immunity, Healing)\n- Citrus fruits, guava, tomatoes\n\n**Vitamin D** (Bones, Mood)\n- Sunlight, fish, eggs, milk\n\n**Iron** (Energy, Focus)\n- Red meat, beans, spinach\n\n**Calcium** (Strong bones & teeth)\n- Milk, cheese, sardines, tofu\n\n**Omega-3** (Brain health)\n- Fish, nuts, seeds\n\n**Best Source:** Balanced diet!\n\n⚠️ Consult doctor before taking supplements.",
                    'related' => ['Vitamin-rich foods', 'Balanced diet', 'Supplement safety']
                ],
                [
                    'keywords' => ['weight', 'timbang', 'lose weight', 'gain weight', 'diet'],
                    'answer' => "⚖️ **Healthy Weight for Teens:**\n\n**Important:**\n- Focus on health, not just weight\n- Every body is different\n- Teens are still growing\n- Avoid crash diets\n- Never skip meals\n\n**Healthy Habits:**\n- Eat balanced meals\n- Regular physical activity\n- Adequate sleep\n- Manage stress\n- Stay hydrated\n\n**Warning Signs:**\n- Obsessing over weight\n- Extreme dieting\n- Skipping meals regularly\n- Excessive exercise\n\n💙 **Love your body!**\n\n⚠️ Concerned about weight? Talk to clinic staff or nutritionist.",
                    'related' => ['Body image', 'Eating disorders', 'Healthy lifestyle']
                ]
            ],
            'daily_health_tips' => [
                [
                    'keywords' => ['exercise', 'workout', 'physical activity', 'ehersisyo'],
                    'answer' => "🏃 **Physical Activity for Students:**\n\n**Recommended:**\n- 60 minutes daily for teens\n- Mix of cardio and strength\n- Activities you enjoy\n\n**Easy Ways to Move:**\n- Walk or bike to school\n- Take stairs instead of elevator\n- Dance to music\n- Play sports\n- Active games with friends\n- Stretch during study breaks\n\n**Benefits:**\n- Better concentration\n- Improved mood\n- More energy\n- Better sleep\n- Stress relief\n- Stronger body\n\n**Tips:**\n- Start small\n- Find a buddy\n- Make it fun\n- Set goals\n\n💙 Move your body, boost your mind!",
                    'related' => ['Exercise routines', 'Sports benefits', 'Stretching exercises']
                ],
                [
                    'keywords' => ['posture', 'sitting', 'back pain', 'likod'],
                    'answer' => "🪑 **Good Posture for Students:**\n\n**Proper Sitting:**\n- Feet flat on floor\n- Back straight, shoulders relaxed\n- Screen at eye level\n- Elbows at 90 degrees\n- Take breaks every 30 minutes\n\n**Standing Posture:**\n- Stand tall\n- Shoulders back\n- Weight evenly distributed\n- Chin parallel to ground\n\n**Carrying Bags:**\n- Use both straps\n- Bag weight < 10% body weight\n- Pack heavy items close to back\n\n**Prevent Back Pain:**\n- Stretch regularly\n- Strengthen core muscles\n- Avoid slouching\n- Proper desk setup\n\n💙 Good posture = Less pain, more energy!",
                    'related' => ['Back exercises', 'Desk ergonomics', 'Stretching routine']
                ],
                [
                    'keywords' => ['screen time', 'phone', 'computer', 'gadget', 'eyes'],
                    'answer' => "📱 **Healthy Screen Time:**\n\n**20-20-20 Rule:**\nEvery 20 minutes, look at something 20 feet away for 20 seconds\n\n**Eye Care:**\n- Blink frequently\n- Adjust screen brightness\n- Reduce glare\n- Proper distance (arm's length)\n- Good lighting\n\n**Limit Screen Time:**\n- No screens 1 hour before bed\n- Take regular breaks\n- Balance with physical activity\n- Set time limits\n\n**Signs of Eye Strain:**\n- Headaches\n- Blurry vision\n- Dry eyes\n- Neck/shoulder pain\n\n💙 Your eyes need breaks too!",
                    'related' => ['Blue light effects', 'Eye exercises', 'Digital wellness']
                ],
                [
                    'keywords' => ['immune', 'immunity', 'sick', 'sakit', 'prevention'],
                    'answer' => "🛡️ **Boost Your Immune System:**\n\n**Daily Habits:**\n- Eat colorful fruits & vegetables\n- Get 7-9 hours sleep\n- Exercise regularly\n- Manage stress\n- Stay hydrated\n- Wash hands frequently\n\n**Immune-Boosting Foods:**\n- Citrus fruits (Vitamin C)\n- Garlic and ginger\n- Yogurt (probiotics)\n- Leafy greens\n- Nuts and seeds\n- Fish\n\n**Avoid:**\n- Smoking and vaping\n- Excessive alcohol\n- Too much sugar\n- Lack of sleep\n- Chronic stress\n\n💙 Strong immunity = Fewer sick days!",
                    'related' => ['Immune system foods', 'Preventing illness', 'Healthy lifestyle']
                ]
            ]
        ];
    }

    /**
     * Get all available topics
     */
    public function getTopics(): array
    {
        $topics = [];
        foreach ($this->knowledgeBase as $category => $items) {
            $topics[$category] = array_map(function($item) {
                return $item['keywords'][0];
            }, $items);
        }
        return $topics;
    }

    /**
     * Get random health tip
     */
    public function getHealthTip(): string
    {
        $tips = [
            "💙 Drink at least 8 glasses of water daily to stay hydrated!",
            "🏃 Get at least 30 minutes of physical activity every day!",
            "🥗 Eat a variety of colorful fruits and vegetables for better nutrition!",
            "😴 Teens need 7-9 hours of sleep for optimal health and learning!",
            "🧼 Wash your hands regularly - it's your best defense against germs!",
            "📱 Take breaks from screens every 20 minutes to rest your eyes!",
            "🧘 Practice deep breathing when stressed - it really helps!",
            "🦷 Brush your teeth twice daily and floss once for healthy smiles!",
            "☀️ Use sunscreen to protect your skin from harmful UV rays!",
            "🤗 Mental health is just as important as physical health - talk to someone if you need help!",
            "🍎 Never skip breakfast - it fuels your brain for learning!",
            "💪 Good posture prevents back pain - sit up straight!",
            "🥤 Limit sugary drinks - choose water instead!",
            "🎯 Set small, achievable health goals and celebrate progress!",
            "🌈 Eat the rainbow - different colored foods provide different nutrients!",
            "🚶 Take the stairs instead of the elevator for easy exercise!",
            "🧠 Your brain needs breaks - take 5-10 minute study breaks!",
            "💚 Spend time in nature - it's great for mental health!",
            "🤝 Strong friendships boost your immune system and happiness!",
            "📚 Balance is key - make time for study, play, and rest!",
            "🥜 Healthy snacks like nuts and fruits give sustained energy!",
            "🎵 Music can reduce stress and improve your mood!",
            "🏋️ Strength training builds strong bones and muscles!",
            "🌙 Create a bedtime routine for better sleep quality!",
            "🥛 Calcium-rich foods build strong bones and teeth!",
            "🧘‍♀️ Stretching improves flexibility and reduces injury risk!",
            "💭 Positive self-talk boosts confidence and reduces anxiety!",
            "🍊 Vitamin C helps fight off colds and infections!",
            "🚰 Carry a water bottle to remind yourself to drink water!",
            "🎨 Creative activities reduce stress and boost happiness!"
        ];

        return $tips[array_rand($tips)];
    }
}
