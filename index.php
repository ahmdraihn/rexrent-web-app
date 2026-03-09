<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REX RENTS | Brutal Car Rental Indonesia</title>
    <meta name="description" content="Best quality cars. Cheapest prices. No bullshit.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brutal: {
                            black: '#0a0a0a',
                            white: '#fafafa',
                            gray: '#888888',
                            accent: '#ccff00',
                            accentDark: '#99cc00',
                        }
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'monospace'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    borderWidth: {
                        '3': '3px',
                        '4': '4px',
                    },
                    boxShadow: {
                        'brutal': '8px 8px 0px 0px #0a0a0a',
                        'brutal-lg': '12px 12px 0px 0px #0a0a0a',
                        'brutal-sm': '4px 4px 0px 0px #0a0a0a',
                    }
                }
            }
        }
    </script>
    
    <style>
        * {
            border-color: #0a0a0a;
        }
        
        ::selection {
            background: #ccff00;
            color: #0a0a0a;
        }
        
        .brutal-border {
            border: 3px solid #0a0a0a;
        }
        
        .brutal-border-hover:hover {
            border-color: #ccff00;
        }
        
        .grid-bg {
            background-image: 
                linear-gradient(rgba(10, 10, 10, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(10, 10, 10, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        
        .marquee {
            animation: marquee 20s linear infinite;
        }
        
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        .glitch {
            position: relative;
        }
        
        .glitch::before,
        .glitch::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .glitch::before {
            animation: glitch-1 0.3s infinite;
            color: #ccff00;
            z-index: -1;
        }
        
        .glitch::after {
            animation: glitch-2 0.3s infinite;
            color: #ff00ff;
            z-index: -2;
        }
        
        @keyframes glitch-1 {
            0%, 100% { clip-path: inset(0 0 0 0); transform: translate(0); }
            20% { clip-path: inset(20% 0 60% 0); transform: translate(-3px, 3px); }
            40% { clip-path: inset(40% 0 40% 0); transform: translate(3px, -3px); }
            60% { clip-path: inset(60% 0 20% 0); transform: translate(-3px, 3px); }
            80% { clip-path: inset(80% 0 0% 0); transform: translate(3px, -3px); }
        }
        
        @keyframes glitch-2 {
            0%, 100% { clip-path: inset(0 0 0 0); transform: translate(0); }
            20% { clip-path: inset(60% 0 20% 0); transform: translate(3px, -3px); }
            40% { clip-path: inset(20% 0 60% 0); transform: translate(-3px, 3px); }
            60% { clip-path: inset(80% 0 0% 0); transform: translate(3px, -3px); }
            80% { clip-path: inset(40% 0 40% 0); transform: translate(-3px, 3px); }
        }
    </style>
</head>
<body class="bg-brutal-white text-brutal-black font-mono overflow-x-hidden">
    
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-brutal-white border-b-4 border-brutal-black">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <a href="#" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-brutal-black flex items-center justify-center border-3 border-brutal-black group-hover:bg-brutal-accent transition-colors">
                        <span class="text-2xl font-display font-bold text-brutal-white group-hover:text-brutal-black">R</span>
                    </div>
                    <span class="font-display font-bold text-xl tracking-tighter hidden sm:block">REX RENTS</span>
                </a>
                
                <div class="hidden md:flex items-center gap-8">
                    <a href="#fleet" class="font-mono font-bold hover:text-brutal-accent-dark transition-colors uppercase tracking-wider">[Fleet]</a>
                    <a href="#pricing" class="font-mono font-bold hover:text-brutal-accent-dark transition-colors uppercase tracking-wider">[Pricing]</a>
                    <a href="#about" class="font-mono font-bold hover:text-brutal-accent-dark transition-colors uppercase tracking-wider">[About]</a>
                    <a href="#contact" class="font-mono font-bold hover:text-brutal-accent-dark transition-colors uppercase tracking-wider">[Contact]</a>
                </div>
                
                <a href="login.php" class="bg-brutal-black text-brutal-white font-mono font-bold px-6 py-3 border-3 border-brutal-black hover:bg-brutal-accent hover:text-brutal-black transition-all shadow-brutal-sm hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                    LOGIN →
                </a>
                
                <button class="md:hidden p-2" onclick="toggleMenu()">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-width="3" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t-4 border-brutal-black bg-brutal-white">
            <div class="flex flex-col p-4 gap-4">
                <a href="#fleet" class="font-mono font-bold hover:bg-brutal-accent px-4 py-2">[FLEET]</a>
                <a href="#pricing" class="font-mono font-bold hover:bg-brutal-accent px-4 py-2">[PRICING]</a>
                <a href="#about" class="font-mono font-bold hover:bg-brutal-accent px-4 py-2">[ABOUT]</a>
                <a href="#contact" class="font-mono font-bold hover:bg-brutal-accent px-4 py-2">[CONTACT]</a>
                <a href="login.php" class="bg-brutal-black text-brutal-white font-mono font-bold px-4 py-3 text-center">LOGIN →</a>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center pt-20 grid-bg">
        <div class="max-w-7xl mx-auto px-4 py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-block bg-brutal-accent px-4 py-2 mb-6 border-3 border-brutal-black">
                        <span class="font-mono font-bold text-sm">/// INDONESIA'S #1 CAR RENTAL</span>
                    </div>
                    
                    <h1 class="font-display font-bold text-6xl md:text-7xl lg:text-8xl leading-none mb-8" data-text="BEST QUALITY">
                        BEST<br>
                        <span class="text-transparent bg-brutal-accent px-4">QUALITY</span><br>
                        CARS
                    </h1>
                    
                    <p class="font-mono text-lg md:text-xl mb-10 max-w-xl border-l-4 border-brutal-accent pl-6">
                        No bullshit. No hidden fees. Just premium cars at prices that don't make you cry. 
                        Indonesia's most honest car rental service.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#fleet" class="bg-brutal-accent text-brutal-black font-mono font-bold text-lg px-10 py-5 border-4 border-brutal-black shadow-brutal hover:shadow-none hover:translate-x-2 hover:translate-y-2 transition-all text-center">
                            VIEW FLEET →
                        </a>
                        <a href="#pricing" class="bg-brutal-white text-brutal-black font-mono font-bold text-lg px-10 py-5 border-4 border-brutal-black hover:bg-brutal-black hover:text-brutal-white transition-all text-center">
                            SEE PRICES
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-6 mt-16 pt-16 border-t-4 border-brutal-black">
                        <div>
                            <div class="font-display font-bold text-4xl md:text-5xl">27</div>
                            <div class="font-mono text-sm mt-2">PREMIUM CARS</div>
                        </div>
                        <div>
                            <div class="font-display font-bold text-4xl md:text-5xl">2K+</div>
                            <div class="font-mono text-sm mt-2">HAPPY CLIENTS</div>
                        </div>
                        <div>
                            <div class="font-display font-bold text-4xl md:text-5xl">24/7</div>
                            <div class="font-mono text-sm mt-2">SUPPORT</div>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="aspect-square border-4 border-brutal-black bg-brutal-black relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800&q=80" alt="Luxury Car" class="w-full h-full object-cover opacity-80 hover:opacity-100 hover:scale-110 transition-all duration-500">
                        <div class="absolute inset-0 bg-brutal-accent mix-blend-multiply opacity-20"></div>
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-brutal-accent px-8 py-6 border-4 border-brutal-black">
                        <div class="font-display font-bold text-3xl">FROM</div>
                        <div class="font-display font-bold text-5xl">RP 240K</div>
                        <div class="font-mono text-sm">/ DAY</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Marquee Banner -->
    <div class="bg-brutal-accent border-y-4 border-brutal-black py-4 overflow-hidden">
        <div class="marquee whitespace-nowrap">
            <span class="font-mono font-bold text-2xl mx-8">★ BEST PRICES IN INDONESIA</span>
            <span class="font-mono font-bold text-2xl mx-8">★ NO HIDDEN FEES</span>
            <span class="font-mono font-bold text-2xl mx-8">★ PREMIUM CARS</span>
            <span class="font-mono font-bold text-2xl mx-8">★ 24/7 SUPPORT</span>
            <span class="font-mono font-bold text-2xl mx-8">★ INSTANT BOOKING</span>
            <span class="font-mono font-bold text-2xl mx-8">★ BEST PRICES IN INDONESIA</span>
            <span class="font-mono font-bold text-2xl mx-8">★ NO HIDDEN FEES</span>
            <span class="font-mono font-bold text-2xl mx-8">★ PREMIUM CARS</span>
            <span class="font-mono font-bold text-2xl mx-8">★ 24/7 SUPPORT</span>
            <span class="font-mono font-bold text-2xl mx-8">★ INSTANT BOOKING</span>
        </div>
    </div>
    
    <!-- Features Section -->
    <section class="py-24 bg-brutal-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-display font-bold text-5xl md:text-6xl mb-4">WHY <span class="bg-brutal-black text-brutal-white px-4">CHOOSE US</span></h2>
                <p class="font-mono text-lg max-w-2xl mx-auto">We don't do corporate bullshit. Just honest service at honest prices.</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="border-4 border-brutal-black p-8 hover:bg-brutal-accent transition-colors group">
                    <div class="text-6xl mb-6">💰</div>
                    <h3 class="font-display font-bold text-2xl mb-4">BEST PRICES</h3>
                    <p class="font-mono text-sm">Cheapest rates in Indonesia. Find a better price? We'll match it.</p>
                </div>
                
                <div class="border-4 border-brutal-black p-8 hover:bg-brutal-accent transition-colors group">
                    <div class="text-6xl mb-6">🚗</div>
                    <h3 class="font-display font-bold text-2xl mb-4">PREMIUM CARS</h3>
                    <p class="font-mono text-sm">27 well-maintained vehicles. From city cars to supercars.</p>
                </div>
                
                <div class="border-4 border-brutal-black p-8 hover:bg-brutal-accent transition-colors group">
                    <div class="text-6xl mb-6">⚡</div>
                    <h3 class="font-display font-bold text-2xl mb-4">FAST BOOKING</h3>
                    <p class="font-mono text-sm">Book online in 2 minutes. Pick up and drive. No paperwork hell.</p>
                </div>
                
                <div class="border-4 border-brutal-black p-8 hover:bg-brutal-accent transition-colors group">
                    <div class="text-6xl mb-6">🛡️</div>
                    <h3 class="font-display font-bold text-2xl mb-4">FULL INSURANCE</h3>
                    <p class="font-mono text-sm">Every rental includes comprehensive insurance. Drive worry-free.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Fleet Section -->
    <section id="fleet" class="py-24 bg-brutal-white border-y-4 border-brutal-black">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-display font-bold text-5xl md:text-6xl mb-4">OUR <span class="bg-brutal-black text-brutal-white px-4">FLEET</span></h2>
                <p class="font-mono text-lg max-w-2xl mx-auto">27 cars. One simple booking process. Zero complications.</p>
            </div>

            <?php
            require_once 'config.php';
            $conn = connectDB();

            $query = "SELECT * FROM tb_mobil WHERE status = TRUE ORDER BY hargasewa ASC";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                ?>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="border-4 border-brutal-black bg-brutal-white group hover:bg-brutal-accent transition-colors shadow-brutal hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                            <div class="aspect-video border-b-4 border-brutal-black overflow-hidden bg-brutal-black">
                                <img src="assets/images/mobil/<?php echo htmlspecialchars($row['foto']); ?>" alt="<?php echo htmlspecialchars($row['merk'] . ' ' . $row['model']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-6">
                                <div class="font-mono text-xs font-bold mb-2 text-brutal-black">[ <?php echo htmlspecialchars($row['merk']); ?> ]</div>
                                <h3 class="font-display font-bold text-2xl mb-4 text-brutal-black"><?php echo htmlspecialchars($row['model']); ?></h3>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-display font-bold text-3xl text-brutal-black"><?php echo formatRupiah($row['hargasewa']); ?></div>
                                        <div class="font-mono text-xs font-bold text-brutal-black">/ DAY</div>
                                    </div>
                                    <a href="login.php" class="bg-brutal-black text-brutal-white font-mono font-bold px-6 py-3 border-3 border-brutal-black hover:bg-brutal-accent hover:text-brutal-black transition-colors">
                                        RENT →
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            } else {
                echo '<div class="text-center py-20 border-4 border-brutal-black bg-brutal-black text-brutal-white"><p class="font-mono text-xl">[ NO CARS AVAILABLE ]</p></div>';
            }

            $conn->close();
            ?>

            <div class="text-center mt-12">
                <a href="login.php" class="inline-block bg-brutal-black text-brutal-white font-mono font-bold text-lg px-10 py-5 border-4 border-brutal-black shadow-brutal hover:shadow-none hover:translate-x-2 hover:translate-y-2 transition-all">
                    VIEW ALL 27 CARS →
                </a>
            </div>
        </div>
    </section>
    
    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-brutal-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-display font-bold text-5xl md:text-6xl mb-4">SIMPLE <span class="bg-brutal-black text-brutal-white px-4">PRICING</span></h2>
                <p class="font-mono text-lg max-w-2xl mx-auto">No hidden fees. No bullshit. What you see is what you pay.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <!-- Economy -->
                <div class="border-4 border-brutal-black p-8 hover:shadow-brutal-lg hover:translate-x-1 hover:translate-y-1 transition-all bg-brutal-white">
                    <div class="font-mono text-sm mb-4">[ECONOMY]</div>
                    <h3 class="font-display font-bold text-3xl mb-2 text-brutal-black">CITY CARS</h3>
                    <div class="font-mono text-sm mb-6 text-brutal-black">Agya, Brio, Calya</div>
                    <div class="font-display font-bold text-5xl mb-6 text-brutal-black">RP 250K<span class="text-lg font-mono">/day</span></div>
                    <ul class="font-mono text-sm space-y-3 mb-8 text-brutal-black">
                        <li>✓ 4-5 Seats</li>
                        <li>✓ Manual/Auto</li>
                        <li>✓ AC & Radio</li>
                        <li>✓ Perfect for city</li>
                        <li>✓ Fuel Efficient</li>
                    </ul>
                    <a href="#fleet" class="block bg-brutal-black text-brutal-white font-mono font-bold text-center px-6 py-4 border-3 border-brutal-black hover:bg-brutal-accent hover:text-brutal-black transition-colors">
                        BOOK NOW →
                    </a>
                </div>
                
                <!-- MPV/SUV -->
                <div class="border-4 border-brutal-black p-8 bg-brutal-accent relative">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-brutal-black text-brutal-white px-4 py-1 font-mono text-sm font-bold">MOST POPULAR</div>
                    <div class="font-mono text-sm mb-4">[FAMILY]</div>
                    <h3 class="font-display font-bold text-3xl mb-2">MPV & SUV</h3>
                    <div class="font-mono text-sm mb-6">Avanza, Xpander, HRV, Innova</div>
                    <div class="font-display font-bold text-5xl mb-6">RP 350K<span class="text-lg font-mono">/day</span></div>
                    <ul class="font-mono text-sm space-y-3 mb-8">
                        <li>✓ 6-7 Seats</li>
                        <li>✓ Automatic</li>
                        <li>✓ Spacious</li>
                        <li>✓ Family Friendly</li>
                        <li>✓ GPS Ready</li>
                    </ul>
                    <a href="#fleet" class="block bg-brutal-black text-brutal-white font-mono font-bold text-center px-6 py-4 border-3 border-brutal-black hover:bg-brutal-white hover:text-brutal-black transition-colors">
                        BOOK NOW →
                    </a>
                </div>
                
                <!-- Luxury/Supercar -->
                <div class="border-4 border-brutal-black p-8 hover:shadow-brutal-lg hover:translate-x-1 hover:translate-y-1 transition-all bg-brutal-white">
                    <div class="font-mono text-sm mb-4">[LUXURY]</div>
                    <h3 class="font-display font-bold text-3xl mb-2 text-brutal-black">SUPERCARS</h3>
                    <div class="font-mono text-sm mb-6 text-brutal-black">Lamborghini, Bugatti</div>
                    <div class="font-display font-bold text-5xl mb-6 text-brutal-black">RP 18M<span class="text-lg font-mono">/day</span></div>
                    <ul class="font-mono text-sm space-y-3 mb-8 text-brutal-black">
                        <li>✓ 2 Seats</li>
                        <li>✓ 700-1500 HP</li>
                        <li>✓ VIP Delivery</li>
                        <li>✓ Professional Driver Option</li>
                        <li>✓ Events / Photo Shoots</li>
                    </ul>
                    <a href="#fleet" class="block bg-brutal-black text-brutal-white font-mono font-bold text-center px-6 py-4 border-3 border-brutal-black hover:bg-brutal-accent hover:text-brutal-black transition-colors">
                        INQUIRE NOW →
                    </a>
                </div>
            </div>
            
            <!-- Duration Discounts -->
            <div class="mt-16 border-4 border-brutal-black p-8 max-w-3xl mx-auto bg-brutal-white">
                <h3 class="font-display font-bold text-2xl mb-6 text-center text-brutal-black">LONGER RENTAL = BIGGER DISCOUNT</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center border-r-4 border-brutal-black last:border-r-0">
                        <div class="font-mono text-sm text-brutal-black">3-6 DAYS</div>
                        <div class="font-display font-bold text-3xl text-brutal-black">5%</div>
                        <div class="font-mono text-xs text-brutal-black">OFF</div>
                    </div>
                    <div class="text-center border-r-4 border-brutal-black last:border-r-0">
                        <div class="font-mono text-sm text-brutal-black">7-13 DAYS</div>
                        <div class="font-display font-bold text-3xl text-brutal-black">10%</div>
                        <div class="font-mono text-xs text-brutal-black">OFF</div>
                    </div>
                    <div class="text-center border-r-4 border-brutal-black last:border-r-0">
                        <div class="font-mono text-sm text-brutal-black">14-27 DAYS</div>
                        <div class="font-display font-bold text-3xl text-brutal-black">15%</div>
                        <div class="font-mono text-xs text-brutal-black">OFF</div>
                    </div>
                    <div class="text-center">
                        <div class="font-mono text-sm text-brutal-black">28+ DAYS</div>
                        <div class="font-display font-bold text-3xl text-brutal-black">20%</div>
                        <div class="font-mono text-xs text-brutal-black">OFF</div>
                    </div>
                </div>
                <p class="font-mono text-xs text-center mt-6 text-brutal-black">* Prices include basic insurance. Admin fee applies. Fuel not included.</p>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section id="about" class="py-24 bg-brutal-black text-brutal-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="border-4 border-brutal-white p-8">
                        <div class="font-mono text-sm mb-4">[ABOUT US]</div>
                        <h2 class="font-display font-bold text-4xl md:text-5xl mb-6">WE'RE NOT LIKE OTHER RENTAL COMPANIES</h2>
                        <div class="font-mono space-y-4 mb-8">
                            <p>Founded in 2020, Rex Rents was born from frustration. Frustration with hidden fees, outdated cars, and corporate bullshit.</p>
                            <p>We do things differently:</p>
                            <ul class="space-y-2 ml-4">
                                <li>→ Transparent pricing (what you see is what you pay)</li>
                                <li>→ Well-maintained fleet (no beat-up cars)</li>
                                <li>→ Fast booking (2 minutes, not 2 hours)</li>
                                <li>→ Real human support (no chatbots)</li>
                            </ul>
                        </div>
                        <a href="#contact" class="inline-block bg-brutal-accent text-brutal-black font-mono font-bold px-8 py-4 border-4 border-brutal-black hover:shadow-brutal hover:translate-x-1 hover:translate-y-1 transition-all">
                            CONTACT US →
                        </a>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="aspect-square border-4 border-brutal-white relative">
                        <img src="assets/images/logolandingpage.png" alt="Rex Rents" class="absolute inset-0 w-full h-full object-contain p-8">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials -->
    <section class="py-24 bg-brutal-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-display font-bold text-5xl md:text-6xl mb-4">REAL <span class="bg-brutal-black text-brutal-white px-4">REVIEWS</span></h2>
                <p class="font-mono text-lg">Don't take our word for it.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="border-4 border-brutal-black p-8">
                    <div class="text-4xl mb-4">★★★★★</div>
                    <p class="font-mono text-sm mb-6">"Finally a rental company that doesn't screw you over. Best prices, clean cars, no bullshit."</p>
                    <div class="font-display font-bold">— AHMAD R.</div>
                    <div class="font-mono text-xs text-gray-500">Jakarta</div>
                </div>
                
                <div class="border-4 border-brutal-black p-8 bg-brutal-black text-brutal-white">
                    <div class="text-4xl mb-4">★★★★★</div>
                    <p class="font-mono text-sm mb-6">"Rented a BMW for a weekend trip. Car was pristine. Process took 10 minutes. Will use again."</p>
                    <div class="font-display font-bold">— SITI N.</div>
                    <div class="font-mono text-xs text-gray-500">Bandung</div>
                </div>
                
                <div class="border-4 border-brutal-black p-8">
                    <div class="text-4xl mb-4">★★★★★</div>
                    <p class="font-mono text-sm mb-6">"Cheapest rates I found in Indonesia. The Lamborghini rental was a dream. Highly recommend."</p>
                    <div class="font-display font-bold">— BUDI S.</div>
                    <div class="font-mono text-xs text-gray-500">Surabaya</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-brutal-black text-brutal-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-display font-bold text-5xl md:text-6xl mb-4">GET IN <span class="bg-brutal-accent text-brutal-black px-4">TOUCH</span></h2>
                <p class="font-mono text-lg">Questions? We're here. 24/7.</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="border-4 border-brutal-white p-8 text-center hover:bg-brutal-accent hover:text-brutal-black transition-colors">
                    <div class="text-5xl mb-4">📍</div>
                    <h3 class="font-display font-bold text-xl mb-4">ADDRESS</h3>
                    <p class="font-mono text-sm">Jl. Raya Utama No. 123<br>Jakarta, Indonesia</p>
                </div>
                
                <div class="border-4 border-brutal-white p-8 text-center hover:bg-brutal-accent hover:text-brutal-black transition-colors">
                    <div class="text-5xl mb-4">📞</div>
                    <h3 class="font-display font-bold text-xl mb-4">PHONE</h3>
                    <p class="font-mono text-sm">0812-3456-7890<br>0813-9876-5432</p>
                </div>
                
                <div class="border-4 border-brutal-white p-8 text-center hover:bg-brutal-accent hover:text-brutal-black transition-colors">
                    <div class="text-5xl mb-4">📧</div>
                    <h3 class="font-display font-bold text-xl mb-4">EMAIL</h3>
                    <p class="font-mono text-sm">info@rexsrents.com<br>support@rexsrents.com</p>
                </div>
                
                <div class="border-4 border-brutal-white p-8 text-center hover:bg-brutal-accent hover:text-brutal-black transition-colors">
                    <div class="text-5xl mb-4">⏰</div>
                    <h3 class="font-display font-bold text-xl mb-4">HOURS</h3>
                    <p class="font-mono text-sm">Mon - Sun<br>24 Hours</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-24 bg-brutal-accent border-y-4 border-brutal-black">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="font-display font-bold text-5xl md:text-7xl mb-6">READY TO DRIVE?</h2>
            <p class="font-mono text-xl mb-10 max-w-2xl mx-auto">Book your car now. No commitment. No bullshit.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="login.php" class="bg-brutal-black text-brutal-white font-mono font-bold text-lg px-10 py-5 border-4 border-brutal-black shadow-brutal-lg hover:shadow-none hover:translate-x-2 hover:translate-y-2 transition-all">
                    BOOK NOW →
                </a>
                <a href="tel:081234567890" class="bg-brutal-white text-brutal-black font-mono font-bold text-lg px-10 py-5 border-4 border-brutal-black hover:bg-brutal-black hover:text-brutal-white transition-all">
                    📞 0812-3456-7890
                </a>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-brutal-black text-brutal-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-brutal-accent flex items-center justify-center border-3 border-brutal-white">
                            <span class="text-2xl font-display font-bold text-brutal-black">R</span>
                        </div>
                        <span class="font-display font-bold text-xl">REX RENTS</span>
                    </div>
                    <p class="font-mono text-sm">Indonesia's most honest car rental. No bullshit, just great cars at great prices.</p>
                </div>
                
                <div>
                    <h4 class="font-display font-bold text-lg mb-6">[QUICK LINKS]</h4>
                    <ul class="font-mono text-sm space-y-3">
                        <li><a href="#fleet" class="hover:text-brutal-accent transition-colors">→ Fleet</a></li>
                        <li><a href="#pricing" class="hover:text-brutal-accent transition-colors">→ Pricing</a></li>
                        <li><a href="#about" class="hover:text-brutal-accent transition-colors">→ About</a></li>
                        <li><a href="login.php" class="hover:text-brutal-accent transition-colors">→ Login</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-display font-bold text-lg mb-6">[SERVICES]</h4>
                    <ul class="font-mono text-sm space-y-3">
                        <li>Daily Rental</li>
                        <li>Weekly Rental</li>
                        <li>Monthly Rental</li>
                        <li>Chauffeur Service</li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-display font-bold text-lg mb-6">[FOLLOW]</h4>
                    <div class="font-mono text-sm space-y-3">
                        <a href="#" class="block hover:text-brutal-accent transition-colors">→ Facebook</a>
                        <a href="#" class="block hover:text-brutal-accent transition-colors">→ Instagram</a>
                        <a href="#" class="block hover:text-brutal-accent transition-colors">→ Twitter</a>
                    </div>
                </div>
            </div>
            
            <div class="border-t-4 border-brutal-white pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="font-mono text-sm">© <?php echo date('Y'); ?> REX RENTS. ALL RIGHTS RESERVED.</p>
                <div class="font-mono text-sm flex gap-6">
                    <a href="#" class="hover:text-brutal-accent transition-colors">[PRIVACY]</a>
                    <a href="#" class="hover:text-brutal-accent transition-colors">[TERMS]</a>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
