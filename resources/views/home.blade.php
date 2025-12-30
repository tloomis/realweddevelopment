<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Real Web Development - Professional web development services specializing in modern, responsive, and scalable web applications.">
    <title>Real Web Development | Professional Web Development Services</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-content">
                <a href="{{ url('/') }}" class="logo">Real<span class="logo-accent">Web</span>Development</a>
                <div class="nav-menu" id="navMenu">
                    <a href="#home" class="nav-link">Home</a>
                    <a href="#services" class="nav-link">Services</a>
                    <a href="#expertise" class="nav-link">Expertise</a>
                    <a href="#portfolio" class="nav-link">Portfolio</a>
                    <a href="#contact" class="nav-link">Contact</a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="nav-link" style="color: #0891b2; font-weight: 600;">Dashboard</a>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="nav-link" style="color: #0891b2; font-weight: 600;">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="nav-link-button">Login</a>
                    @endauth
                </div>
                <button class="mobile-toggle" id="mobileToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content">
                {{-- Headshot temporarily commented out --}}
                {{-- <div class="hero-profile">
                    <img src="{{ asset('images/todd-loomis-headshot.jpg') }}" alt="Todd Loomis - CTO & Full-Stack Developer" class="hero-headshot">
                </div> --}}
                <h1 class="hero-title">
                    Full-Stack Developer
                    <span class="gradient-text">Building Enterprise</span>
                    Solutions Since 1997
                </h1>
                <p class="hero-subtitle">
                    Experienced IT leader with over 28 years of expertise driving complete lifecycles of web and software development projects. Specialized in PHP, Laravel, React, and cloud architecture delivering scalable enterprise solutions.
                </p>
                <div class="hero-cta">
                    <a href="#contact" class="btn btn-primary">Get In Touch</a>
                    <a href="#portfolio" class="btn btn-secondary">View Portfolio</a>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <div class="stat-number">28+</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">200+</div>
                        <div class="stat-label">Projects Delivered</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">CTO</div>
                        <div class="stat-label">Leadership Role</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">What I Do</span>
                <h2 class="section-title">Services</h2>
                <p class="section-subtitle">Comprehensive web development solutions tailored to your needs</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                    </div>
                    <h3 class="service-title">Web Design</h3>
                    <p class="service-description">Modern, user-centric designs that combine aesthetics with functionality to create exceptional user experiences.</p>
                    <ul class="service-features">
                        <li>Responsive Design</li>
                        <li>UI/UX Design</li>
                        <li>Prototyping</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                    </div>
                    <h3 class="service-title">Full-Stack Development</h3>
                    <p class="service-description">End-to-end development services from frontend interfaces to backend systems and database architecture.</p>
                    <ul class="service-features">
                        <li>Frontend Development</li>
                        <li>Backend Systems</li>
                        <li>API Integration</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                    </div>
                    <h3 class="service-title">Progressive Web Apps</h3>
                    <p class="service-description">Fast, reliable, and engaging web applications that work seamlessly across all devices and platforms.</p>
                    <ul class="service-features">
                        <li>Offline Capability</li>
                        <li>Push Notifications</li>
                        <li>App-like Experience</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <h3 class="service-title">Performance Optimization</h3>
                    <p class="service-description">Maximize speed and efficiency with advanced optimization techniques for better user experience and SEO.</p>
                    <ul class="service-features">
                        <li>Speed Enhancement</li>
                        <li>SEO Optimization</li>
                        <li>Code Refactoring</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </div>
                    <h3 class="service-title">Security & Maintenance</h3>
                    <p class="service-description">Comprehensive security implementations and ongoing maintenance to keep your applications secure and up-to-date.</p>
                    <ul class="service-features">
                        <li>Security Audits</li>
                        <li>Regular Updates</li>
                        <li>Monitoring</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path></svg>
                    </div>
                    <h3 class="service-title">Cloud Solutions</h3>
                    <p class="service-description">Scalable cloud infrastructure setup and migration services for reliable, high-performance applications.</p>
                    <ul class="service-features">
                        <li>Cloud Migration</li>
                        <li>DevOps Setup</li>
                        <li>Scalability</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Expertise Section -->
    <section id="expertise" class="expertise">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Technical Skills</span>
                <h2 class="section-title">Expertise</h2>
                <p class="section-subtitle">Proficient in modern web technologies and frameworks</p>
            </div>
            <div class="expertise-grid">
                <div class="expertise-category">
                    <h3 class="category-title">Languages</h3>
                    <div class="tech-tags">
                        <span class="tech-tag">PHP</span>
                        <span class="tech-tag">JavaScript</span>
                        <span class="tech-tag">Java</span>
                        <span class="tech-tag">Python</span>
                        <span class="tech-tag">SQL</span>
                        <span class="tech-tag">HTML/CSS</span>
                        <span class="tech-tag">XML</span>
                        <span class="tech-tag">JSON</span>
                    </div>
                </div>
                <div class="expertise-category">
                    <h3 class="category-title">Frameworks & CMS</h3>
                    <div class="tech-tags">
                        <span class="tech-tag">Laravel</span>
                        <span class="tech-tag">React</span>
                        <span class="tech-tag">Angular</span>
                        <span class="tech-tag">Node.js</span>
                        <span class="tech-tag">Spring Framework</span>
                        <span class="tech-tag">Magento</span>
                        <span class="tech-tag">WordPress</span>
                        <span class="tech-tag">Hibernate</span>
                    </div>
                </div>
                <div class="expertise-category">
                    <h3 class="category-title">Database & Cloud</h3>
                    <div class="tech-tags">
                        <span class="tech-tag">MySQL</span>
                        <span class="tech-tag">Oracle</span>
                        <span class="tech-tag">PostgreSQL</span>
                        <span class="tech-tag">MongoDB</span>
                        <span class="tech-tag">AWS</span>
                        <span class="tech-tag">Azure</span>
                        <span class="tech-tag">Google Cloud</span>
                    </div>
                </div>
                <div class="expertise-category">
                    <h3 class="category-title">DevOps & Architecture</h3>
                    <div class="tech-tags">
                        <span class="tech-tag">Docker</span>
                        <span class="tech-tag">Kubernetes</span>
                        <span class="tech-tag">RESTful APIs</span>
                        <span class="tech-tag">TOGAF</span>
                        <span class="tech-tag">SEO</span>
                        <span class="tech-tag">HIPAA/GDPR</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Featured Work</span>
                <h2 class="section-title">Portfolio</h2>
                <p class="section-subtitle">Leadership roles and enterprise solutions across multiple industries</p>
            </div>
            <div class="portfolio-grid">
                <!-- ClearBox Appraiser Platform -->
                <div class="portfolio-card portfolio-card-tech">
                    <div class="portfolio-icon-wrapper">
                        <div class="portfolio-icon">CB</div>
                        <div class="portfolio-pattern"></div>
                    </div>
                    <div class="portfolio-header">
                        <div class="portfolio-meta">
                            <span class="portfolio-role role-cto">CTO / Senior Developer</span>
                            <span class="portfolio-timeline">2010-2019, 2023-Present</span>
                        </div>
                        <h3 class="portfolio-title">ClearBox, LLC</h3>
                        <p class="portfolio-subtitle">Property Appraisal Management Platform</p>
                    </div>
                    <p class="portfolio-description">Architected and led development of an enterprise appraiser application with RESTful APIs, ensuring regulatory compliance and scalability for 100k+ subscribers. Managed cross-functional teams of developers and designers while orchestrating email marketing campaigns.</p>
                    <div class="portfolio-tags">
                        <span class="tag">PHP</span>
                        <span class="tag">Laravel</span>
                        <span class="tag">REST APIs</span>
                        <span class="tag">WordPress</span>
                        <span class="tag">Magento</span>
                    </div>
                    <div class="portfolio-impact">
                        <div class="impact-item">
                            <span class="impact-number">100k+</span>
                            <span class="impact-label">Subscribers</span>
                        </div>
                        <div class="impact-item">
                            <span class="impact-number">13+</span>
                            <span class="impact-label">Years</span>
                        </div>
                    </div>
                </div>

                <!-- Hospice Source Platform -->
                <div class="portfolio-card portfolio-card-healthcare">
                    <div class="portfolio-icon-wrapper">
                        <div class="portfolio-icon">HS</div>
                        <div class="portfolio-pattern"></div>
                    </div>
                    <div class="portfolio-header">
                        <div class="portfolio-meta">
                            <span class="portfolio-role role-cto">CTO / Senior Engineer</span>
                            <span class="portfolio-timeline">2019-2023</span>
                        </div>
                        <h3 class="portfolio-title">Hospice Source, LLC</h3>
                        <p class="portfolio-subtitle">Medical Equipment Management System</p>
                    </div>
                    <p class="portfolio-description">Led architecture and development of HIPAA-compliant online medical equipment ordering system with mobile warehouse inventory management application. Conducted extensive R&D and played key role in team recruitment and hiring processes.</p>
                    <div class="portfolio-tags">
                        <span class="tag">PHP</span>
                        <span class="tag">HIPAA</span>
                        <span class="tag">Mobile</span>
                        <span class="tag">Inventory</span>
                        <span class="tag">Security</span>
                    </div>
                    <div class="portfolio-impact">
                        <div class="impact-item">
                            <span class="impact-number">HIPAA</span>
                            <span class="impact-label">Compliant</span>
                        </div>
                        <div class="impact-item">
                            <span class="impact-number">4</span>
                            <span class="impact-label">Years</span>
                        </div>
                    </div>
                </div>

                <!-- D3Corp eCommerce -->
                <div class="portfolio-card portfolio-card-ecommerce">
                    <div class="portfolio-icon-wrapper">
                        <div class="portfolio-icon">D3</div>
                        <div class="portfolio-pattern"></div>
                    </div>
                    <div class="portfolio-header">
                        <div class="portfolio-meta">
                            <span class="portfolio-role role-manager">eCommerce Manager</span>
                            <span class="portfolio-timeline">2008-2010</span>
                        </div>
                        <h3 class="portfolio-title">D3Corp</h3>
                        <p class="portfolio-subtitle">Custom Magento Solutions</p>
                    </div>
                    <p class="portfolio-description">Engineered custom eCommerce solutions on the Magento platform with bespoke modules to enhance functionality and user experience. Conducted client demonstrations, training sessions, and collaborated with teams to develop in-house CMS and specialized applications.</p>
                    <div class="portfolio-tags">
                        <span class="tag">Magento</span>
                        <span class="tag">PHP</span>
                        <span class="tag">eCommerce</span>
                        <span class="tag">Custom Modules</span>
                    </div>
                    <div class="portfolio-impact">
                        <div class="impact-item">
                            <span class="impact-number">Custom</span>
                            <span class="impact-label">Modules</span>
                        </div>
                        <div class="impact-item">
                            <span class="impact-number">CMS</span>
                            <span class="impact-label">Platform</span>
                        </div>
                    </div>
                </div>

                <!-- New Village Media -->
                <div class="portfolio-card portfolio-card-media">
                    <div class="portfolio-icon-wrapper">
                        <div class="portfolio-icon">NV</div>
                        <div class="portfolio-pattern"></div>
                    </div>
                    <div class="portfolio-header">
                        <div class="portfolio-meta">
                            <span class="portfolio-role role-director">Director of Development</span>
                            <span class="portfolio-timeline">2007-2008</span>
                        </div>
                        <h3 class="portfolio-title">New Village Media</h3>
                        <p class="portfolio-subtitle">CMS & Multimedia Platform</p>
                    </div>
                    <p class="portfolio-description">Led complete redesign of proprietary CMS optimizing performance and usability. Developed and integrated multimedia features including HD FLV uploader and video player. Managed development teams and collaborated with marketing and SEO teams for business alignment.</p>
                    <div class="portfolio-tags">
                        <span class="tag">PHP</span>
                        <span class="tag">CMS</span>
                        <span class="tag">Multimedia</span>
                        <span class="tag">SEO</span>
                        <span class="tag">Video</span>
                    </div>
                    <div class="portfolio-impact">
                        <div class="impact-item">
                            <span class="impact-number">HD</span>
                            <span class="impact-label">Video</span>
                        </div>
                        <div class="impact-item">
                            <span class="impact-number">SEO</span>
                            <span class="impact-label">Optimized</span>
                        </div>
                    </div>
                </div>

                <!-- Tray Business Systems -->
                <div class="portfolio-card portfolio-card-enterprise">
                    <div class="portfolio-icon-wrapper">
                        <div class="portfolio-icon">TB</div>
                        <div class="portfolio-pattern"></div>
                    </div>
                    <div class="portfolio-header">
                        <div class="portfolio-meta">
                            <span class="portfolio-role role-director">eCommerce/IT Director</span>
                            <span class="portfolio-timeline">2005-2007</span>
                        </div>
                        <h3 class="portfolio-title">Tray Business Systems</h3>
                        <p class="portfolio-subtitle">Online Imprint eCommerce Platform</p>
                    </div>
                    <p class="portfolio-description">Architected online imprint eCommerce platform for customizable business collateral, driving revenue growth. Generated online sales reports to support strategic decision-making and developed customized demo sites to showcase product capabilities to prospective clients.</p>
                    <div class="portfolio-tags">
                        <span class="tag">PHP</span>
                        <span class="tag">eCommerce</span>
                        <span class="tag">Customization</span>
                        <span class="tag">B2B</span>
                    </div>
                    <div class="portfolio-impact">
                        <div class="impact-item">
                            <span class="impact-number">Revenue</span>
                            <span class="impact-label">Growth</span>
                        </div>
                        <div class="impact-item">
                            <span class="impact-number">Demo</span>
                            <span class="impact-label">Sites</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="contact-wrapper">
                <div class="contact-info">
                    <span class="section-badge">Get In Touch</span>
                    <h2 class="section-title">Let's Discuss Your Next Project</h2>
                    <p class="contact-description">
                        As an experienced IT leader with over 28 years of expertise, I specialize in architecting enterprise solutions, managing development teams, and delivering scalable web applications. Whether you need a custom platform, compliance-focused system, or technical leadership, I'm here to help bring your vision to life.
                    </p>
                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            </div>
                            <div>
                                <div class="contact-label">Email</div>
                                <a href="mailto:info@realwebdevelopment.com" class="contact-value">info@realwebdevelopment.com</a>
                            </div>
                        </div>
                        {{-- Phone temporarily commented out --}}
                        {{-- <div class="contact-item">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            </div>
                            <div>
                                <div class="contact-label">Phone</div>
                                <a href="tel:443-953-0628" class="contact-value">443-953-0628</a>
                            </div>
                        </div> --}}
                        {{-- Location temporarily commented out --}}
                        {{-- <div class="contact-item">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                            <div>
                                <div class="contact-label">Location</div>
                                <span class="contact-value">St. Johns, FL</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="contact-form-wrapper">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-error">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="contact-form" id="contactForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
                            @error('subject')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <a href="{{ url('/') }}" class="logo">Real<span class="logo-accent">Web</span>Development</a>
                    <p class="footer-description">Building exceptional web experiences with modern technologies.</p>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h4>Services</h4>
                        <a href="#services">Web Design</a>
                        <a href="#services">Development</a>
                        <a href="#services">Consulting</a>
                    </div>
                    <div class="footer-column">
                        <h4>Company</h4>
                        <a href="#portfolio">Portfolio</a>
                        <a href="#expertise">Expertise</a>
                        <a href="#contact">Contact</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Real Web Development. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/contact-handler.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
