<?php
session_start();
require_once __DIR__ . '/includes/db.php';

// --- Role-aware redirect for logged-in users ---
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':   header('Location: pages/dashboard.php'); exit;
        case 'student': header('Location: pages/dashboard.php'); exit;
        case 'company': header('Location: pages/dashboard.php'); exit;
    }
}

// --- Live Stats ---
$stats = ['total_students' => 0, 'total_companies' => 0, 'total_internships' => 0, 'total_placements' => 0];
$internships = [];
try {
    $pdo = getDB();
    $row = $pdo->query("
        SELECT
            (SELECT COUNT(*) FROM students) AS total_students,
            (SELECT COUNT(*) FROM companies WHERE verified=1) AS total_companies,
            (SELECT COUNT(*) FROM internships) AS total_internships,
            (SELECT COUNT(*) FROM placements) AS total_placements
    ")->fetch();
    if ($row) $stats = $row;

    $stmt = $pdo->query("
        SELECT i.internship_id, i.title, c.city, i.stipend, i.domain,
               i.duration_months, i.start_date, i.end_date, i.slots,
               c.company_name, i.status
        FROM internships i
        JOIN companies c ON i.company_id = c.company_id
        WHERE i.status = 'open' AND c.verified = 1
        ORDER BY i.start_date DESC
        LIMIT 6
    ");
    $internships = $stmt->fetchAll();
} catch (PDOException $e) {
    // Graceful fallback — page renders with zeros
}

$browseHref = isset($_SESSION['user_id']) ? 'pages/internships.php' : 'auth/login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InternBridge PK — Find Your Internship</title>
    <meta name="description" content="InternBridge PK connects Pakistani students with verified companies for internship opportunities across Karachi, Lahore, Islamabad and beyond.">
    <link rel="stylesheet" href="assets/css/design-system.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="stylesheet" href="assets/css/landing.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="ib-landing">

<!-- ═══ SHADER CANVAS ═══ -->
<canvas id="ib-shader-canvas" aria-hidden="true"></canvas>

<!-- ═══ NAVBAR ═══ -->
<nav id="ib-nav" class="ib-nav">
    <div class="ib-nav__inner">
        <a href="index.php" class="ib-nav__logo">
            <span class="ib-logo-icon"><i data-lucide="graduation-cap"></i></span>
            <span class="ib-logo-text">InternBridge <em>PK</em></span>
        </a>
        <ul class="ib-nav__links" id="ib-nav-links">
            <li><a href="#hero" class="ib-nav__link">Home</a></li>
            <li><a href="#how-it-works" class="ib-nav__link">How It Works</a></li>
            <li><a href="#internships" class="ib-nav__link">Browse</a></li>
            <li><a href="#about" class="ib-nav__link">About</a></li>
            <span class="ib-nav__pill" id="ib-nav-pill"></span>
        </ul>
        <div class="ib-nav__cta">
            <a href="auth/login.php" class="btn btn-ghost">Login</a>
            <a href="auth/login.php" class="btn btn-primary">Register</a>
        </div>
        <button class="ib-nav__hamburger" id="ib-hamburger" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<!-- ═══ HERO ═══ -->
<section id="hero" class="ib-hero">
    <div class="ib-hero__content ib-reveal">
        <div class="ib-hero__badge">
            <i data-lucide="flag" style="width:16px;height:16px"></i>
            For Pakistani Students & Companies
        </div>
        <h1 class="ib-hero__title">
            Find Your <span class="ib-gradient-text">First Step</span><br>
            Toward a Career
        </h1>
        <p class="ib-hero__sub">
            InternBridge PK connects talented Pakistani students with verified
            companies across Karachi, Lahore, Islamabad, Peshawar and beyond.
        </p>
        <div class="ib-hero__actions">
            <a href="auth/login.php" class="btn btn-primary btn-lg">
                <i data-lucide="graduation-cap" style="width:18px;height:18px"></i> I'm a Student
            </a>
            <a href="auth/login.php" class="btn btn-outline btn-lg">
                <i data-lucide="building-2" style="width:18px;height:18px"></i> I'm a Company
            </a>
        </div>
    </div>
    <div class="ib-hero__deco" aria-hidden="true">
        <div class="ib-deco__ring ib-deco__ring--1"></div>
        <div class="ib-deco__ring ib-deco__ring--2"></div>
        <div class="ib-deco__ring ib-deco__ring--3"></div>
        <div class="ib-deco__orb"></div>
    </div>
</section>

<!-- ═══ STATS ═══ -->
<section class="ib-stats ib-reveal">
    <div class="ib-stats__grid">
        <div class="ib-stat" data-target="<?= (int)$stats['total_internships'] ?>">
            <span class="ib-stat__number">0</span>
            <span class="ib-stat__label">Internships Posted</span>
        </div>
        <div class="ib-stat" data-target="<?= (int)$stats['total_students'] ?>">
            <span class="ib-stat__number">0</span>
            <span class="ib-stat__label">Students Registered</span>
        </div>
        <div class="ib-stat" data-target="<?= (int)$stats['total_companies'] ?>">
            <span class="ib-stat__number">0</span>
            <span class="ib-stat__label">Verified Companies</span>
        </div>
        <div class="ib-stat" data-target="<?= (int)$stats['total_placements'] ?>">
            <span class="ib-stat__number">0</span>
            <span class="ib-stat__label">Successful Placements</span>
        </div>
    </div>
</section>

<!-- ═══ HOW IT WORKS ═══ -->
<section id="how-it-works" class="ib-section">
    <h2 class="ib-section__title ib-reveal">How It Works</h2>
    <div class="ib-hiw__tracks">
        <div class="ib-hiw__track ib-reveal">
            <h3 class="ib-hiw__track-title"><i data-lucide="graduation-cap"></i> For Students</h3>
            <div class="ib-hiw__steps">
                <div class="ib-step"><div class="ib-step__num">1</div><div class="ib-step__text"><h4>Register Free</h4><p>Create your account in under a minute</p></div></div>
                <div class="ib-step"><div class="ib-step__num">2</div><div class="ib-step__text"><h4>Build Your Profile</h4><p>Add your education, skills, and upload CV</p></div></div>
                <div class="ib-step"><div class="ib-step__num">3</div><div class="ib-step__text"><h4>Browse Internships</h4><p>Filter by city, field, and stipend range</p></div></div>
                <div class="ib-step"><div class="ib-step__num">4</div><div class="ib-step__text"><h4>Apply with Cover Letter</h4><p>Stand out with a personalized application</p></div></div>
                <div class="ib-step"><div class="ib-step__num">5</div><div class="ib-step__text"><h4>Get Placed</h4><p>Land your first internship and start your career</p></div></div>
            </div>
        </div>
        <div class="ib-hiw__track ib-reveal">
            <h3 class="ib-hiw__track-title"><i data-lucide="building-2"></i> For Companies</h3>
            <div class="ib-hiw__steps">
                <div class="ib-step"><div class="ib-step__num">1</div><div class="ib-step__text"><h4>Register Company</h4><p>Set up your company profile with details</p></div></div>
                <div class="ib-step"><div class="ib-step__num">2</div><div class="ib-step__text"><h4>Get Admin Verified</h4><p>Our team verifies your company identity</p></div></div>
                <div class="ib-step"><div class="ib-step__num">3</div><div class="ib-step__text"><h4>Post Listings</h4><p>Create internship opportunities in minutes</p></div></div>
                <div class="ib-step"><div class="ib-step__num">4</div><div class="ib-step__text"><h4>Review Applicants</h4><p>Shortlist and manage candidates easily</p></div></div>
                <div class="ib-step"><div class="ib-step__num">5</div><div class="ib-step__text"><h4>Place Talent</h4><p>Accept and onboard the right interns</p></div></div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ INTERNSHIP PREVIEW ═══ -->
<section id="internships" class="ib-section">
    <div class="ib-section__header ib-reveal">
        <h2 class="ib-section__title" style="margin-bottom:0;text-align:left">Latest Open Internships</h2>
        <a href="<?= htmlspecialchars($browseHref) ?>" class="btn btn-outline">View All <i data-lucide="arrow-right" style="width:16px;height:16px"></i></a>
    </div>
    <div class="ib-cards__grid">
        <?php foreach ($internships as $i): ?>
        <div class="ib-icard ib-reveal">
            <div class="ib-icard__top">
                <div class="ib-icard__company">
                    <div class="ib-icard__logo-placeholder"><?= strtoupper(substr($i['company_name'],0,1)) ?></div>
                    <span class="ib-icard__company-name"><?= htmlspecialchars($i['company_name']) ?></span>
                </div>
                <div class="ib-icard__badges">
                    <?php if ($i['stipend'] > 0): ?>
                        <span class="badge badge-green"><i data-lucide="banknote" style="width:12px;height:12px"></i> Paid</span>
                    <?php else: ?>
                        <span class="badge badge-gray">Unpaid</span>
                    <?php endif; ?>
                </div>
            </div>
            <h4 class="ib-icard__title"><?= htmlspecialchars($i['title']) ?></h4>
            <div class="ib-icard__meta">
                <span><i data-lucide="map-pin" style="width:14px;height:14px"></i> <?= htmlspecialchars($i['city']) ?></span>
                <span><i data-lucide="clock" style="width:14px;height:14px"></i> <?= (int)$i['duration_months'] ?> months</span>
            </div>
            <?php if ($i['stipend'] > 0): ?>
                <div class="ib-icard__stipend">PKR <?= number_format($i['stipend']) ?>/month</div>
            <?php endif; ?>
            <div class="ib-icard__footer">
                <span class="ib-icard__deadline">Start: <?= date('d M Y', strtotime($i['start_date'])) ?></span>
                <a href="<?= htmlspecialchars($browseHref) ?>" class="btn btn-primary btn-sm">Apply <i data-lucide="arrow-right" style="width:14px;height:14px"></i></a>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($internships)): ?>
            <p class="ib-empty">No open internships right now. Check back soon!</p>
        <?php endif; ?>
    </div>
</section>

<!-- ═══ FEATURES ═══ -->
<section id="about" class="ib-section">
    <h2 class="ib-section__title ib-reveal">Why InternBridge?</h2>
    <div class="ib-features__grid">
        <div class="ib-features__col ib-reveal">
            <h3><i data-lucide="graduation-cap"></i> For Students</h3>
            <ul>
                <li><i data-lucide="search"></i> Browse internships filtered by city, field, and stipend</li>
                <li><i data-lucide="file-text"></i> Apply with a cover letter and upload your CV</li>
                <li><i data-lucide="bar-chart-3"></i> Track all your applications in one dashboard</li>
                <li><i data-lucide="star"></i> Rate companies after your internship ends</li>
                <li><i data-lucide="bell"></i> Get notified when your status changes</li>
            </ul>
            <a href="auth/login.php" class="btn btn-primary">Get Started Free</a>
        </div>
        <div class="ib-features__col ib-reveal">
            <h3><i data-lucide="building-2"></i> For Companies</h3>
            <ul>
                <li><i data-lucide="megaphone"></i> Post internship listings in minutes</li>
                <li><i data-lucide="users"></i> Manage and shortlist applicants easily</li>
                <li><i data-lucide="shield-check"></i> Build trust with admin-verified badges</li>
                <li><i data-lucide="trending-up"></i> Track your open positions and placements</li>
                <li><i data-lucide="bell"></i> Get notified when students apply</li>
            </ul>
            <a href="auth/login.php" class="btn btn-outline">Register Company</a>
        </div>
    </div>
</section>

<!-- ═══ MARQUEE ═══ -->
<section class="ib-marquee-section">
    <p class="ib-marquee__label">Students from top universities</p>
    <div class="ib-marquee">
        <div class="ib-marquee__track">
            <span>FAST-NUCES</span><span>NUST</span><span>UET Lahore</span>
            <span>COMSATS</span><span>IBA Karachi</span><span>GIKI</span>
            <span>QAU</span><span>University of Peshawar</span>
            <span>LUMS</span><span>Air University</span>
            <span>NED University</span><span>ITU Lahore</span>
            <span>FAST-NUCES</span><span>NUST</span><span>UET Lahore</span>
            <span>COMSATS</span><span>IBA Karachi</span><span>GIKI</span>
            <span>QAU</span><span>University of Peshawar</span>
            <span>LUMS</span><span>Air University</span>
            <span>NED University</span><span>ITU Lahore</span>
        </div>
    </div>
</section>

<!-- ═══ TESTIMONIALS ═══ -->
<section class="ib-section">
    <h2 class="ib-section__title ib-reveal">What Our Users Say</h2>
    <div class="ib-testi__grid">
        <div class="ib-testi__card ib-reveal">
            <p class="ib-testi__quote">"InternBridge helped me land my first internship at a Karachi-based fintech in just 2 weeks. The process was incredibly smooth."</p>
            <div class="ib-testi__author">
                <div class="ib-testi__avatar">AK</div>
                <div><strong>Ayesha Khan</strong><span>CS Student, FAST Karachi</span></div>
            </div>
        </div>
        <div class="ib-testi__card ib-reveal">
            <p class="ib-testi__quote">"We hired 3 interns through InternBridge last quarter. The verified student profiles saved us so much screening time."</p>
            <div class="ib-testi__author">
                <div class="ib-testi__avatar">MR</div>
                <div><strong>M. Raza</strong><span>HR Manager, TechVentures Lahore</span></div>
            </div>
        </div>
        <div class="ib-testi__card ib-reveal">
            <p class="ib-testi__quote">"The platform is simple and clean. I applied to 5 companies and tracked every application status in one place."</p>
            <div class="ib-testi__author">
                <div class="ib-testi__avatar">UB</div>
                <div><strong>Usman Baig</strong><span>Software Intern, Islamabad</span></div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ FOOTER ═══ -->
<footer class="ib-footer">
    <div class="ib-footer__inner">
        <div class="ib-footer__brand">
            <span class="ib-logo-text">InternBridge <em>PK</em></span>
            <p>Connecting Pakistani talent with opportunity. We bridge the gap between education and industry across all major cities.</p>
        </div>
        <div class="ib-footer__links">
            <h4>Platform</h4>
            <a href="auth/login.php">Login</a>
            <a href="auth/login.php">Student Register</a>
            <a href="auth/login.php">Company Register</a>
            <a href="pages/dashboard.php">Admin Panel</a>
        </div>
        <div class="ib-footer__cities">
            <h4>Cities We Serve</h4>
            <p>Karachi · Lahore · Islamabad · Peshawar · Quetta · Multan · Faisalabad · Hyderabad</p>
        </div>
    </div>
    <div class="ib-footer__bottom">
        &copy; <?= date('Y') ?> InternBridge PK. Built for Pakistani Students.
    </div>
</footer>

<!-- ═══ INLINE SCRIPTS ═══ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    if (window.lucide) lucide.createIcons();

    /* ─── 1. THREE.JS CYBERNETIC GRID SHADER ─── */
    (function() {
        var canvas = document.getElementById('ib-shader-canvas');
        if (!canvas || typeof THREE === 'undefined') return;

        var renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: false });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.setSize(window.innerWidth, window.innerHeight);

        var camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);
        var scene = new THREE.Scene();
        var clock = new THREE.Clock();

        var uniforms = {
            iTime: { value: 0.0 },
            iResolution: { value: new THREE.Vector2(window.innerWidth, window.innerHeight) },
            iMouse: { value: new THREE.Vector2(window.innerWidth / 2, window.innerHeight / 2) }
        };

        var vertexShader = [
            'void main() {',
            '  gl_Position = vec4(position, 1.0);',
            '}'
        ].join('\n');

        var fragmentShader = [
            'uniform float iTime;',
            'uniform vec2 iResolution;',
            'uniform vec2 iMouse;',
            '',
            'float hash(vec2 p) {',
            '    return fract(sin(dot(p, vec2(127.1, 311.7))) * 43758.5453);',
            '}',
            'float noise(vec2 p) {',
            '    vec2 i = floor(p);',
            '    vec2 f = fract(p);',
            '    f = f * f * (3.0 - 2.0 * f);',
            '    return mix(mix(hash(i), hash(i+vec2(1,0)), f.x),',
            '               mix(hash(i+vec2(0,1)), hash(i+vec2(1,1)), f.x), f.y);',
            '}',
            'void main() {',
            '    vec2 uv = gl_FragCoord.xy / iResolution.xy;',
            '    vec2 mouse = iMouse / iResolution;',
            '    vec2 gp = fract(uv * 25.0);',
            '    float gx = smoothstep(0.0, 0.03, gp.x) * smoothstep(0.0, 0.03, 1.0-gp.x);',
            '    float gy = smoothstep(0.0, 0.03, gp.y) * smoothstep(0.0, 0.03, 1.0-gp.y);',
            '    float grid = 1.0 - gx * gy;',
            '    float pulse = sin(uv.x * 50.0 - iTime * 3.0) * 0.5 + 0.5;',
            '    pulse *= sin(uv.y * 50.0 + iTime * 2.0) * 0.5 + 0.5;',
            '    float dist = distance(uv, mouse);',
            '    float glow = exp(-dist * 4.5) * 0.7;',
            '    float n = noise(uv * 8.0 + iTime * 0.2) * 0.12;',
            '    vec2 fc = fract(uv * 25.0) - 0.5;',
            '    float dot2 = smoothstep(0.12, 0.08, length(fc));',
            '    float crossPulse = sin(uv.x * 25.0 * 3.14159 + iTime) * sin(uv.y * 25.0 * 3.14159 - iTime * 0.7);',
            '    vec3 bg = vec3(0.015, 0.015, 0.045);',
            '    vec3 gc = vec3(0.24, 0.35, 0.996);',
            '    vec3 glowC = vec3(0.3, 0.5, 1.0);',
            '    vec3 col = bg;',
            '    col += gc * grid * (0.08 + pulse * 0.06);',
            '    col += gc * dot2 * (0.15 + crossPulse * 0.08);',
            '    col += glowC * glow;',
            '    col += n * vec3(0.04, 0.06, 0.12);',
            '    col *= 1.0 + glow * 0.5;',
            '    gl_FragColor = vec4(col, 1.0);',
            '}'
        ].join('\n');

        var material = new THREE.ShaderMaterial({
            uniforms: uniforms,
            vertexShader: vertexShader,
            fragmentShader: fragmentShader
        });
        var mesh = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), material);
        scene.add(mesh);

        window.addEventListener('resize', function() {
            renderer.setSize(window.innerWidth, window.innerHeight);
            uniforms.iResolution.value.set(window.innerWidth, window.innerHeight);
        });
        window.addEventListener('mousemove', function(e) {
            uniforms.iMouse.value.set(e.clientX, canvas.height - e.clientY);
        });

        (function animate() {
            requestAnimationFrame(animate);
            uniforms.iTime.value = clock.getElapsedTime();
            renderer.render(scene, camera);
        })();
    })();

    /* ─── 2. NAVBAR PILL + SCROLL ─── */
    (function() {
        var nav = document.getElementById('ib-nav');
        var pill = document.getElementById('ib-nav-pill');
        var linksUl = document.getElementById('ib-nav-links');
        if (!nav || !pill || !linksUl) return;

        var items = linksUl.querySelectorAll('li');
        items.forEach(function(li) {
            li.addEventListener('mouseenter', function() {
                var liRect = li.getBoundingClientRect();
                var ulRect = linksUl.getBoundingClientRect();
                var offsetLeft = liRect.left - ulRect.left;
                pill.style.left = offsetLeft + 'px';
                pill.style.width = liRect.width + 'px';
                pill.style.opacity = '1';
            });
        });
        linksUl.addEventListener('mouseleave', function() {
            pill.style.opacity = '0';
        });

        window.addEventListener('scroll', function() {
            nav.classList.toggle('ib-nav--scrolled', window.scrollY > 60);
        }, { passive: true });
    })();

    /* ─── 3. HAMBURGER ─── */
    (function() {
        var btn = document.getElementById('ib-hamburger');
        var links = document.getElementById('ib-nav-links');
        if (!btn || !links) return;
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            links.classList.toggle('open');
            btn.classList.toggle('active');
        });
        document.addEventListener('click', function(e) {
            if (!links.contains(e.target) && !btn.contains(e.target)) {
                links.classList.remove('open');
                btn.classList.remove('active');
            }
        });
    })();

    /* ─── 4. COUNTUP ─── */
    (function() {
        var statsEl = document.querySelector('.ib-stats');
        if (!statsEl) return;
        var animated = false;

        function easeOutQuart(t) { return 1 - Math.pow(1 - t, 4); }

        function animateCountUp() {
            if (animated) return;
            animated = true;
            var els = statsEl.querySelectorAll('[data-target]');
            els.forEach(function(el) {
                var target = parseInt(el.getAttribute('data-target'), 10) || 0;
                var numEl = el.querySelector('.ib-stat__number');
                var start = performance.now();
                var duration = 2000;
                (function tick(now) {
                    var progress = Math.min((now - start) / duration, 1);
                    numEl.textContent = Math.round(easeOutQuart(progress) * target);
                    if (progress < 1) requestAnimationFrame(tick);
                })(start);
            });
        }

        var obs = new IntersectionObserver(function(entries) {
            if (entries[0].isIntersecting) animateCountUp();
        }, { threshold: 0.3 });
        obs.observe(statsEl);
    })();

    /* ─── 5. SCROLL REVEAL ─── */
    (function() {
        var reveals = document.querySelectorAll('.ib-reveal');
        if (!reveals.length) return;
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('ib-reveal--visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        reveals.forEach(function(el) { obs.observe(el); });
    })();
});
</script>
</body>
</html>
