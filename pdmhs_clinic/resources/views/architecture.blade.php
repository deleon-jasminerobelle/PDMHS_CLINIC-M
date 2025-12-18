<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Architecture - PDMHS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #3b82f6;
            --accent: #60a5fa;
            --dark: #0f172a;
            --gray: #64748b;
            --light: #f1f5f9;
            --white: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
            --gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #f8fafc, #e0f2fe);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navigation */
        nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(30, 64, 175, 0.1);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo::before {
            content: "🏥";
            font-size: 32px;
            -webkit-text-fill-color: initial;
        }

        .nav-links {
            display: flex;
            gap: 8px;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            color: var(--gray);
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
            background: var(--light);
            transform: translateY(-2px);
        }

        .nav-links a.active {
            color: var(--primary);
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        }

        /* Hero Section */
        .page-hero {
            padding: 140px 2rem 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: 50%;
            transform: translateX(-50%);
            width: 1000px;
            height: 1000px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .page-hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: var(--primary);
            padding: 10px 24px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 24px;
            border: 1px solid rgba(30, 64, 175, 0.2);
        }

        .hero-badge::before {
            content: "🏗️";
        }

        .page-hero h1 {
            font-size: clamp(40px, 6vw, 64px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 24px;
            letter-spacing: -2px;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-hero p {
            font-size: 20px;
            color: var(--gray);
            line-height: 1.8;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Architecture Section */
        .architecture-section {
            padding: 80px 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .architecture-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 60px;
            margin-bottom: 80px;
        }

        .architecture-card {
            background: var(--white);
            border-radius: 24px;
            padding: 48px;
            transition: all 0.4s ease;
            border: 1px solid rgba(30, 64, 175, 0.1);
            position: relative;
            overflow: hidden;
        }

        .architecture-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient);
        }