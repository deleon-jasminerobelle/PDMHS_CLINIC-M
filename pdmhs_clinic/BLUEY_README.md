# 🩺 Bluey Health Bot - Documentation

## Overview

Bluey is an AI-powered health Q&A chatbot integrated into the PDMHS Student Medical System. Bluey helps students get quick answers to common health questions, first aid tips, and medical term explanations.

## Features

### 1. Health Q&A
- Answer common health questions (headaches, fever, cough, stomach issues)
- Provide evidence-based health information
- Easy-to-understand explanations

### 2. First Aid Tips
- Step-by-step first aid instructions
- Emergency response guidance
- When to seek medical help

### 3. Medical Terms Explained
- Simple explanations of medical conditions
- Symptoms and management tips
- Prevention strategies

### 4. Health Tips
- Random daily health tips
- Wellness reminders
- Preventive care advice

## How to Access

**URL:** `http://your-domain.com/bluey`

Students can access Bluey directly without logging in, making health information accessible to everyone.

## Knowledge Base Categories

### Common Health Issues
- Headaches
- Fever
- Cough & Sore Throat
- Stomach Problems (Diarrhea, Vomiting)

### First Aid
- Cuts & Wounds
- Burns
- Sprains
- Nosebleeds

### Medical Terms
- Hypertension
- Diabetes
- Asthma
- Anemia

### Hygiene
- Proper Handwashing
- Dental Care

### Mental Health
- Stress & Anxiety Management
- Sleep Tips

## API Endpoints

### 1. Chat Interface
```
GET /bluey
```
Opens the Bluey chat interface

### 2. Ask Question
```
POST /bluey/ask
Content-Type: application/json

{
    "question": "What causes headaches?"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "question": "what causes headaches?",
        "answer": "💙 **Headache Relief Tips:**...",
        "category": "common_health",
        "confidence": 0.85,
        "related_topics": [
            "What causes headaches?",
            "Migraine vs regular headache",
            "Dehydration symptoms"
        ]
    }
}
```

### 3. Get Random Health Tip
```
GET /bluey/tip
```

**Response:**
```json
{
    "success": true,
    "tip": "💙 Drink at least 8 glasses of water daily to stay hydrated!"
}
```

### 4. Get All Topics
```
GET /bluey/topics
```

**Response:**
```json
{
    "success": true,
    "topics": {
        "common_health": ["headache", "fever", "cough", "stomach"],
        "first_aid": ["cut", "burn", "sprain", "nosebleed"],
        "medical_terms": ["hypertension", "diabetes", "asthma", "anemia"],
        "hygiene": ["handwashing", "dental"],
        "mental_health": ["stress", "sleep"]
    }
}
```

## How It Works

### Keyword Matching Algorithm

Bluey uses a simple but effective keyword matching system:

1. User asks a question
2. Question is converted to lowercase
3. System searches through knowledge base for keyword matches
4. Calculates confidence score based on keyword matches
5. Returns best matching answer
6. Provides related topics for further exploration

### Confidence Scoring

- **High Confidence (>0.7):** Strong keyword match
- **Medium Confidence (0.3-0.7):** Partial match
- **Low Confidence (<0.3):** No clear match, returns default help message

## Adding New Knowledge

To add new health topics, edit `app/Services/BlueyHealthBot.php`:

```php
'category_name' => [
    [
        'keywords' => ['keyword1', 'keyword2', 'tagalog_word'],
        'answer' => "Your formatted answer here...",
        'related' => ['Related topic 1', 'Related topic 2']
    ]
]
```

### Answer Formatting

Use markdown-style formatting:
- `**Bold text**` for emphasis
- `\n\n` for paragraphs
- Emojis for visual appeal
- `⚠️` for warnings
- Numbered lists for steps

## Integration with Main System

### Adding Bluey Link to Navigation

Add to your main navigation menu:

```html
<a href="{{ route('bluey.chat') }}" class="nav-link">
    🩺 Ask Bluey
</a>
```

### Embedding in Dashboard

You can embed Bluey in student dashboard:

```blade
<div class="bluey-widget">
    <h3>💙 Ask Bluey</h3>
    <p>Have a health question?</p>
    <a href="{{ route('bluey.chat') }}" class="btn btn-primary">
        Chat with Bluey
    </a>
</div>
```

### Quick Health Tip Widget

Display random health tips:

```blade
<div class="health-tip-widget">
    <div id="daily-tip">Loading tip...</div>
</div>

<script>
fetch('/bluey/tip')
    .then(res => res.json())
    .then(data => {
        document.getElementById('daily-tip').innerHTML = data.tip;
    });
</script>
```

## Future Enhancements

### Planned Features

1. **AI Integration**
   - OpenAI API for more intelligent responses
   - Natural language understanding
   - Context-aware conversations

2. **Personalization**
   - Remember user preferences
   - Personalized health tips based on student profile
   - Health history integration

3. **Multilingual Support**
   - Full Tagalog translation
   - Language switching

4. **Voice Input**
   - Speech-to-text for questions
   - Text-to-speech for answers

5. **Analytics**
   - Track most asked questions
   - Identify knowledge gaps
   - Usage statistics

6. **Emergency Features**
   - Emergency contact quick dial
   - Location-based clinic finder
   - Urgent care triage

## Safety & Disclaimers

### Important Notes

⚠️ **Bluey is NOT a replacement for professional medical advice**

- Bluey provides general health information only
- Always consult clinic staff for serious concerns
- In emergencies, seek immediate medical attention
- Information is for educational purposes

### Disclaimer Text

Add this to your chat interface:

```
"Bluey provides general health information and is not a substitute 
for professional medical advice, diagnosis, or treatment. Always 
seek the advice of your physician or qualified health provider 
with any questions you may have regarding a medical condition."
```

## Maintenance

### Regular Updates

- Review and update health information quarterly
- Add new topics based on student questions
- Update medical guidelines as needed
- Test all responses for accuracy

### Monitoring

- Check logs for unanswered questions
- Identify common topics needing more detail
- Monitor user feedback
- Track response accuracy

## Support

For technical issues or to suggest new health topics:
- Contact: Clinic Staff
- Email: [clinic email]
- Submit feedback through the system

---

**Built with ❤️ for PDMHS Students**

*Making health information accessible, friendly, and easy to understand!*
