@extends('client.dashboard')

@section('client-content')
<div class="min-h-full">
    <!-- Main Content -->
    <div class="md:pl-64 flex flex-col flex-1">
        <main class="flex-1 p-6">
            <!-- Bienvenue Section avec Animation et Citation -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg mb-8 overflow-hidden relative">
                <div class="absolute inset-0 bg-pattern opacity-10"></div>
                <div class="relative z-10 p-8">
                    <div class="flex items-center animate-fadeIn">
                        <div class="mr-5">
                            <svg class="w-14 h-14 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white tracking-tight">Bienvenue, {{ auth()->user()->prenom }}!</h1>
                            <p class="text-blue-100 mt-1 max-w-2xl">{{ now()->format('l, d F Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 animate-slideUp" style="animation-delay: 0.2s">
                        <blockquote class="italic text-white text-lg">
                            "Le partage d'objets n'est pas seulement une façon de vivre plus économiquement, c'est aussi une façon de vivre plus intensément - en connectant des personnes et créant des communautés."
                        </blockquote>
                        <p class="text-right text-blue-100 mt-2">- L'équipe de MediaRent</p>
                    </div>
                </div>
                
                <!-- Décoration de fond -->
                <div class="absolute -bottom-8 -right-8 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute -top-16 -left-16 w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl"></div>
            </div>
            
            <!-- Stats Cards modernisées -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Card: Ongoing Reservations -->
                <div class="bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-blue-100 dark:border-blue-900/30 p-6 transition-all hover:shadow-2xl hover:scale-105 hover:border-blue-300 animate-fadeIn relative overflow-hidden" style="animation-delay: 0.3s">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-400/10 rounded-full -mr-10 -mt-10 blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-indigo-400/10 rounded-full -ml-6 -mb-6 blur-xl"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-sm font-medium text-blue-600/80 dark:text-blue-400/80 uppercase tracking-wider">Réservations en cours</p>
                            <div class="flex items-center">
                                <p class="text-4xl font-extrabold text-blue-600 dark:text-blue-400 mt-1 counter-animate" data-target="{{ $ongoingReservations ?? 0 }}">0</p>
                                @if(($ongoingReservations ?? 0) > 0)
                                <span class="ml-2 text-xs font-medium px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400">Active</span>
                                @endif
                            </div>
                            <div class="flex items-center mt-2">
                                <span class="text-xs font-medium text-green-600 dark:text-green-400 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    +15% ce mois
                                </span>
                            </div>
                        </div>
                        <div class="p-4 rounded-xl bg-blue-500/10 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 relative overflow-hidden backdrop-blur-sm border border-blue-500/20 dark:border-blue-800/30">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <div class="absolute inset-0 bg-blue-400/20 scale-0 rounded-full animate-ping-slow"></div>
                        </div>
                    </div>
                    <!-- Mini chart -->
                    <div class="h-10 mt-4 w-full">
                        <svg class="w-full h-full" viewBox="0 0 100 20">
                            <path d="M0,10 L10,12 L20,8 L30,15 L40,9 L50,12 L60,7 L70,15 L80,5 L90,10 L100,5" 
                                  fill="none" 
                                  stroke="rgba(59, 130, 246, 0.6)" 
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"></path>
                            <path d="M0,10 L10,12 L20,8 L30,15 L40,9 L50,12 L60,7 L70,15 L80,5 L90,10 L100,5" 
                                  fill="rgba(59, 130, 246, 0.1)"></path>
                        </svg>
                    </div>
                </div>

                <!-- Card: Past Reservations -->
                <div class="bg-gradient-to-br from-white to-green-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-green-100 dark:border-green-900/30 p-6 transition-all hover:shadow-2xl hover:scale-105 hover:border-green-300 animate-fadeIn relative overflow-hidden" style="animation-delay: 0.4s">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-400/10 rounded-full -mr-10 -mt-10 blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-teal-400/10 rounded-full -ml-6 -mb-6 blur-xl"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-sm font-medium text-green-600/80 dark:text-green-400/80 uppercase tracking-wider">Réservations passées</p>
                            <div class="flex items-center">
                                <p class="text-4xl font-extrabold text-green-600 dark:text-green-400 mt-1 counter-animate" data-target="{{ $pastReservations ?? 0 }}">0</p>
                            </div>
                            <div class="flex items-center mt-2">
                                <span class="text-xs font-medium text-green-600 dark:text-green-400 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    +24% ce trimestre
                                </span>
                            </div>
                        </div>
                        <div class="p-4 rounded-xl bg-green-500/10 dark:bg-green-900/30 text-green-600 dark:text-green-400 relative overflow-hidden backdrop-blur-sm border border-green-500/20 dark:border-green-800/30">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div class="absolute inset-0 bg-green-400/20 scale-0 rounded-full animate-ping-slow"></div>
                        </div>
                    </div>
                    <!-- Mini chart -->
                    <div class="h-10 mt-4 w-full">
                        <svg class="w-full h-full" viewBox="0 0 100 20">
                            <path d="M0,15 L10,13 L20,14 L30,10 L40,12 L50,7 L60,5 L70,3 L80,2 L90,3 L100,2" 
                                  fill="none" 
                                  stroke="rgba(16, 185, 129, 0.6)" 
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"></path>
                            <path d="M0,15 L10,13 L20,14 L30,10 L40,12 L50,7 L60,5 L70,3 L80,2 L90,3 L100,2"
                                  fill="rgba(16, 185, 129, 0.1)"></path>
                        </svg>
                    </div>
                </div>

                <!-- Card: Average Rating -->
                <div class="bg-gradient-to-br from-white to-yellow-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-yellow-100 dark:border-yellow-900/30 p-6 transition-all hover:shadow-2xl hover:scale-105 hover:border-yellow-300 animate-fadeIn relative overflow-hidden" style="animation-delay: 0.5s">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-400/10 rounded-full -mr-10 -mt-10 blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-amber-400/10 rounded-full -ml-6 -mb-6 blur-xl"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-sm font-medium text-yellow-600/80 dark:text-yellow-400/80 uppercase tracking-wider">Note moyenne</p>
                            <div class="flex items-center mt-1">
                                <p class="text-4xl font-extrabold text-yellow-600 dark:text-yellow-400 mr-2 counter-animate-decimal" data-target="{{ number_format($averageRating ?? 0, 1) }}">0.0</p>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($averageRating ?? 0))
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @elseif($i - 0.5 <= ($averageRating ?? 0))
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient id="half-star" x1="0" x2="100%" y1="0" y2="0">
                                                        <stop offset="50%" stop-color="currentColor"></stop>
                                                        <stop offset="50%" stop-color="#D1D5DB"></stop>
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half-star)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <div class="flex items-center mt-2">
                                <span class="text-xs font-medium text-yellow-600 dark:text-yellow-400">
                                    Basée sur {{ ($pastReservations ?? 0) }} évaluations
                                </span>
                            </div>
                        </div>
                        <div class="p-4 rounded-xl bg-yellow-500/10 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 relative overflow-hidden backdrop-blur-sm border border-yellow-500/20 dark:border-yellow-800/30">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            <div class="absolute inset-0 bg-yellow-400/20 scale-0 rounded-full animate-ping-slow"></div>
                        </div>
                    </div>
                    <!-- Mini chart -->
                    <div class="h-10 mt-4 w-full">
                        <svg class="w-full h-full" viewBox="0 0 100 20">
                            <path d="M0,10 L10,8 L20,12 L30,9 L40,11 L50,7 L60,9 L70,8 L80,5 L90,7 L100,4" 
                                  fill="none" 
                                  stroke="rgba(245, 158, 11, 0.6)" 
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"></path>
                            <path d="M0,10 L10,8 L20,12 L30,9 L40,11 L50,7 L60,9 L70,8 L80,5 L90,7 L100,4" 
                                  fill="rgba(245, 158, 11, 0.1)"></path>
                        </svg>
                    </div>
                </div>
            </div>

            
        </main>
    </div>
</div>

@push('styles')
<style>
    .bg-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes ping-slow {
        0% { transform: scale(0.2); opacity: 0.8; }
        80% { transform: scale(1.2); opacity: 0; }
        100% { transform: scale(2.2); opacity: 0; }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.8s ease-out forwards;
    }
    
    .animate-slideUp {
        animation: slideUp 0.8s ease-out forwards;
    }
    
    .animate-ping-slow {
        animation: ping-slow 3s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Animation pour les compteurs
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des compteurs
        const counters = document.querySelectorAll('.counter-animate');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 1500;
            const stepTime = Math.abs(Math.floor(duration / target) || 50);
            
            let current = 0;
            const timer = setInterval(() => {
                current += 1;
                counter.textContent = current;
                if (current >= target) {
                    clearInterval(timer);
                    counter.textContent = target;
                }
            }, stepTime);
            // Animation des compteurs décimaux
            const decimalCounters = document.querySelectorAll('.counter-animate-decimal');
            decimalCounters.forEach(counter => {
                const target = parseFloat(counter.getAttribute('data-target'));
                const duration = 1500;
                const steps = 50;
                const stepValue = target / steps;
                
                let current = 0;
                const timer = setInterval(() => {
                    current += stepValue;
                    counter.textContent = current.toFixed(1);
                    if (current >= target) {
                        clearInterval(timer);
                        counter.textContent = target.toFixed(1);
                    }
                }, duration / steps);
            });
        });

        // Graphique d'évolution des réservations
        const reservationsChartOptions = {
            series: [{
                name: 'Réservations',
                data: [12, 19, 15, 25, 22, 30, 28]
            }],
            chart: {
                height: 350,
                type: 'area',
                fontFamily: 'Inter, sans-serif',
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                },
                dropShadow: {
                    enabled: true,
                    top: 6,
                    left: 0,
                    blur: 6,
                    opacity: 0.15
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            colors: ['#4F46E5'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.1,
                    stops: [0, 95, 100]
                }
            },
            grid: {
                borderColor: '#e2e8f0',
                strokeDashArray: 5,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 10
                }
            },
            xaxis: {
                categories: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil'],
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '12px',
                        fontWeight: 500
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '12px',
                        fontWeight: 500
                    },
                    formatter: function (val) {
                        return val.toFixed(0);
                    }
                }
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
                y: {
                    formatter: function (val) {
                        return val.toFixed(0) + " réservations";
                    }
                },
                theme: 'dark',
                style: {
                    fontSize: '12px',
                    fontFamily: 'Inter, sans-serif'
                }
            },
            markers: {
                size: 5,
                strokeWidth: 0,
                hover: {
                    size: 7
                }
            },
            responsive: [{
                breakpoint: 1024,
                options: {
                    chart: {
                        height: 300
                    }
                }
            }]
        };

        // Initialisation du graphique
        const reservationsChart = new ApexCharts(document.querySelector("#reservations-chart"), reservationsChartOptions);
        reservationsChart.render();

        // Mode sombre / clair adaptatif pour le graphique
        function updateChartTheme(isDark) {
            const newOptions = {
                grid: {
                    borderColor: isDark ? '#334155' : '#e2e8f0'
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light'
                }
            };
            reservationsChart.updateOptions(newOptions);
        }

        // Détection du mode sombre
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            updateChartTheme(true);
        }

        // Écouter les changements de mode
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            updateChartTheme(e.matches);
        });
</script>
@endpush
@endsection