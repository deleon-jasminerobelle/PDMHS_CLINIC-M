# 🚀 Bluey Health Bot - Quick Setup Guide

## What's Been Created

### 1. Backend Files
- ✅ `app/Services/BlueyHealthBot.php` - Core bot logic and knowledge base
- ✅ `app/Http/Controllers/BlueyBotController.php` - API endpoints

### 2. Frontend Files
- ✅ `resources/views/bluey/chat.blade.php` - Chat interface

### 3. Routes
- ✅ Added to `routes/web.php`:
  - `GET /bluey` - Chat interface
  - `POST /bluey/ask` - Ask questions
  - `GET /bluey/tip` - Get health tips
  - `GET /bluey/topics` - Get all topics

### 4. Documentation
- ✅ `BLUEY_README.md` - Complete documentation
- ✅ `BLUEY_SETUP.md` - This file

## How to Test

### 1. Start Your Laravel Server

```bash
cd PDMHS_CLINIC-M/pdmhs_clinic
php artisan serve
```

### 2. Access Bluey

Open your browser and go to:
```
http://localhost:8000/bluey
```

### 3. Try These Questions

- "What causes headaches?"
- "How to treat fever?"
- "First aid for cuts"
- "What is hypertension?"
- "Proper handwashing"
- "How to manage stress?"

## Features to Test

### ✅ Basic Chat
1. Type a health question
2. Press Enter or click Send
3. Bluey responds with answer

### ✅ Quick Topics
1. Click any quick topic button
2. Auto-fills question and sends

### ✅ Related Topics
1. After getting an answer
2. Click related topic links
3. Asks follow-up questions

### ✅ Health Tips
1. See random tip in header
2. Refresh page for new tip

## Customization

### Change Bluey's Avatar

Edit `resources/views/bluey/chat.blade.php`:

```html
<!-- Line 95 - Change emoji -->
<div class="bluey-avatar">🩺</div>

<!-- Or use image -->
<div class="bluey-avatar">
    <img src="/images/bluey.png" alt="Bluey">
</div>
```

### Add More Health Topics

Edit `app/Services/BlueyHealthBot.php`:

```php
// Add to loadKnowledgeBase() method
'your_category' => [
    [
        'keywords' => ['keyword1', 'keyword2'],
        'answer' => "Your answer here...",
        'related' => ['Related topic 1']
    ]
]
```

### Change Colors

Edit `resources/views/bluey/chat.blade.php` CSS:

```css
/* Main color - Line 30 */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* Bluey's color - Line 42 */
background: linear-gradient(135deg, #5B9FED 0%, #4A90E2 100%);
```

## Integration with Your System

### Add to Navigation Menu

In your main layout file (e.g., `resources/views/layouts/app.blade.php`):

```blade
<nav>
    <!-- Your existing menu items -->
    <a href="{{ route('bluey.chat') }}" class="nav-link">
        🩺 Ask Bluey
    </a>
</nav>
```

### Add to Student Dashboard

In `resources/views/student/dashboard.blade.php`:

```blade
<div class="card">
    <div class="card-header">
        <h3>💙 Health Questions?</h3>
    </div>
    <div class="card-body">
        <p>Ask Bluey, your friendly health buddy!</p>
        <a href="{{ route('bluey.chat') }}" class="btn btn-primary">
            Chat with Bluey
        </a>
    </div>
</div>
```

### Add Health Tip Widget

Anywhere in your views:

```blade
<div class="health-tip-widget">
    <h4>💡 Daily Health Tip</h4>
    <p id="bluey-tip">Loading...</p>
</div>

<script>
fetch('/bluey/tip')
    .then(res => res.json())
    .then(data => {
        document.getElementById('bluey-tip').textContent = data.tip;
    });
</script>
```

## Troubleshooting

### Issue: 404 Not Found

**Solution:** Clear route cache
```bash
php artisan route:clear
php artisan route:cache
```

### Issue: CSRF Token Mismatch

**Solution:** Check meta tag in HTML head
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

### Issue: Bluey Not Responding

**Solution:** Check browser console for errors
- Press F12
- Go to Console tab
- Look for JavaScript errors

### Issue: Styling Looks Broken

**Solution:** Hard refresh browser
- Windows: `Ctrl + F5`
- Mac: `Cmd + Shift + R`

## Next Steps

### 1. Add More Content
- Review student questions
- Add more health topics
- Update existing answers

### 2. Improve Matching
- Add more keywords
- Include Tagalog terms
- Test with real questions

### 3. Analytics (Optional)
- Track popular questions
- Log unanswered queries
- Monitor usage patterns

### 4. AI Integration (Future)
- OpenAI API for smarter responses
- Natural language processing
- Context-aware conversations

## Support

Need help? Check:
1. `BLUEY_README.md` - Full documentation
2. Laravel logs: `storage/logs/laravel.log`
3. Browser console for frontend errors

## Success Checklist

- [ ] Server running
- [ ] Can access `/bluey`
- [ ] Can send messages
- [ ] Bluey responds correctly
- [ ] Quick topics work
- [ ] Related topics clickable
- [ ] Health tips display
- [ ] Mobile responsive

---

**Congratulations! Bluey is ready to help your students! 🎉**

*Making health information accessible to everyone!* 💙
