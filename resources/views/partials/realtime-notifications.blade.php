@auth
@php
    $currentUser = Auth::user();
    $pusherKey = site_setting('pusher_app_key', config('broadcasting.connections.pusher.key', env('PUSHER_APP_KEY', 'b76dcc5b20ab5a7da366')));
    $pusherCluster = site_setting('pusher_app_cluster', config('broadcasting.connections.pusher.options.cluster', env('PUSHER_APP_CLUSTER', 'ap2')));
    $pusherEnabled = site_is_enabled('pusher_enabled', true) && ($currentUser->push_notifications_enabled ?? true);
    $soundEnabled = site_is_enabled('push_notification_sound_enabled', true);
    $soundAudioUrl = asset('assets/audio/notification.mp3');
@endphp

@if($pusherEnabled && !empty($pusherKey))
<!-- Realtime Notification Floating Toast Container (Bottom-Right) -->
<div id="realtime-toast-container" class="fixed bottom-5 right-5 z-[99999] flex flex-col gap-3 max-w-sm sm:max-w-md w-full pointer-events-none px-4 sm:px-0">
</div>

<!-- Load Official Pusher Client via CDN -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
(function() {
    const SOUND_ENABLED = {{ $soundEnabled ? 'true' : 'false' }};
    const AUDIO_FILE_URL = "{{ $soundAudioUrl }}";
    let audioUnlocked = false;
    let audioCtx = null;

    // Unlock browser audio context on user interaction
    function unlockAudio() {
        if (audioUnlocked) return;
        audioUnlocked = true;
        try {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (AudioContext) {
                if (!audioCtx) audioCtx = new AudioContext();
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
            }
        } catch(e) {}
    }

    window.addEventListener('click', unlockAudio, { once: true, passive: true });
    window.addEventListener('touchstart', unlockAudio, { once: true, passive: true });
    window.addEventListener('keydown', unlockAudio, { once: true, passive: true });

    // Play Notification Audio (MP3 file with Web Audio fallback)
    function playNotificationAudio() {
        if (!SOUND_ENABLED) return;

        try {
            const audio = new Audio(AUDIO_FILE_URL);
            audio.volume = 1.0;
            const playPromise = audio.play();
            if (playPromise !== undefined) {
                playPromise.catch(function(err) {
                    console.debug('Direct MP3 playback restricted, using synthesizer chime:', err);
                    playSynthesizedChime();
                });
            }
        } catch (err) {
            playSynthesizedChime();
        }
    }

    // Fallback Web Audio Synthesizer
    function playSynthesizedChime() {
        try {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (!AudioContext) return;
            if (!audioCtx) audioCtx = new AudioContext();
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }

            const now = audioCtx.currentTime;
            
            // Note 1 (E5 - 659.25Hz)
            const osc1 = audioCtx.createOscillator();
            const gain1 = audioCtx.createGain();
            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(659.25, now);
            gain1.gain.setValueAtTime(0, now);
            gain1.gain.linearRampToValueAtTime(0.2, now + 0.03);
            gain1.gain.exponentialRampToValueAtTime(0.0001, now + 0.35);
            osc1.connect(gain1);
            gain1.connect(audioCtx.destination);
            osc1.start(now);
            osc1.stop(now + 0.35);

            // Note 2 (A5 - 880.00Hz)
            const osc2 = audioCtx.createOscillator();
            const gain2 = audioCtx.createGain();
            osc2.type = 'sine';
            osc2.frequency.setValueAtTime(880.00, now + 0.12);
            gain2.gain.setValueAtTime(0, now + 0.12);
            gain2.gain.linearRampToValueAtTime(0.25, now + 0.15);
            gain2.gain.exponentialRampToValueAtTime(0.0001, now + 0.55);
            osc2.connect(gain2);
            gain2.connect(audioCtx.destination);
            osc2.start(now + 0.12);
            osc2.stop(now + 0.55);
        } catch (err) {
            console.debug('Synthesized chime error:', err);
        }
    }

    // Dynamic Navbar Notification List & Badge Update
    function updateNavbarDropdownAndBadges(data) {
        // 1. Update all navbar notification badges
        const badges = document.querySelectorAll('.notification-unread-count-badge, #admin-navbar-notif-badge, #user-navbar-notif-badge');
        let newCount = 1;
        badges.forEach(badge => {
            badge.classList.remove('hidden');
            const current = parseInt(badge.textContent.trim(), 10) || 0;
            newCount = current + 1;
            badge.textContent = newCount > 9 ? '9+' : newCount;
        });

        // 2. Update unread text in dropdown headers
        const adminText = document.getElementById('admin-navbar-unread-text');
        if (adminText) {
            adminText.className = 'text-[10px] font-bold bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-400 px-2 py-0.5 rounded-full';
            adminText.textContent = newCount + ' Unread';
        }

        const userText = document.getElementById('user-navbar-unread-text');
        if (userText) {
            userText.className = 'text-[10px] font-bold bg-blue-100 dark:bg-blue-950 text-[#0067b8] dark:text-sky-400 px-2 py-0.5 rounded-full';
            userText.textContent = newCount + ' New';
        }

        // 3. Insert notification item into dropdown list
        const lists = [
            document.getElementById('admin-navbar-notif-list'),
            document.getElementById('user-navbar-notif-list')
        ];

        const icon = data.icon || 'fa-solid fa-bell';
        const title = data.title || 'Notification';
        const message = data.message || '';
        const color = data.color || 'emerald';
        const id = data.id || '';
        
        let targetUrl = data.action_url || '#';
        @if($currentUser->role === 'admin')
            if (id) targetUrl = '/admin/notifications/' + id + '/go';
        @else
            if (id) targetUrl = '/user/notifications/' + id + '/go';
        @endif

        const colorClasses = {
            emerald: 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 border border-emerald-200 dark:border-emerald-800',
            amber: 'bg-amber-50 dark:bg-amber-950/60 text-amber-600 border border-amber-200 dark:border-amber-800',
            rose: 'bg-rose-50 dark:bg-rose-950/60 text-rose-600 border border-rose-200 dark:border-rose-800',
            purple: 'bg-purple-50 dark:bg-purple-950/60 text-purple-600 border border-purple-200 dark:border-purple-800',
            blue: 'bg-blue-50 dark:bg-blue-950/60 text-[#0067b8] dark:text-sky-400 border border-blue-200 dark:border-blue-800',
            slate: 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700'
        };

        const iconColorClass = colorClasses[color] || colorClasses.emerald;

        lists.forEach(list => {
            if (!list) return;

            // Remove empty placeholder if present
            const emptyStates = list.querySelectorAll('.empty-notif-placeholder, .text-center');
            emptyStates.forEach(el => el.remove());

            const itemLink = document.createElement('a');
            itemLink.href = targetUrl;
            itemLink.className = 'p-3.5 flex items-start gap-3 bg-amber-50/40 dark:bg-amber-950/30 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors block group animate-in fade-in slide-in-from-top-2 duration-300';
            
            itemLink.innerHTML = `
                <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 text-xs mt-0.5 ${iconColorClass}">
                    <i class="${icon}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-1">
                        <p class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-[#0067b8] dark:group-hover:text-sky-400 transition-colors truncate">${title}</p>
                        <span class="text-[10px] text-slate-400 shrink-0">Just now</span>
                    </div>
                    <p class="text-[11px] text-slate-600 dark:text-slate-300 font-medium truncate mt-0.5">${message}</p>
                    <span class="inline-block mt-1 text-[9px] font-black bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 px-1.5 py-0.5 rounded">Action Needed</span>
                </div>
            `;

            // Insert at the very top of the list
            list.insertBefore(itemLink, list.firstChild);
        });
    }

    // Render Floating Toast Notification at Bottom-Right
    function showNotificationToast(data) {
        playNotificationAudio();
        updateNavbarDropdownAndBadges(data);

        const container = document.getElementById('realtime-toast-container');
        if (!container) return;

        const toastId = 'toast_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5);
        const icon = data.icon || 'fa-solid fa-bell';
        const title = data.title || 'New Notification';
        const message = data.message || '';
        const actionUrl = data.action_url || '#';

        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `pointer-events-auto w-full bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-4 shadow-2xl transition-all duration-300 transform translate-y-6 opacity-0 flex flex-col overflow-hidden relative`;
        
        toast.innerHTML = `
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 text-base shadow-xs">
                    <i class="${icon}"></i>
                </div>
                <div class="flex-1 min-w-0 pr-6">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 px-2 py-0.2 rounded">Realtime</span>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white truncate">${title}</h4>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-snug line-clamp-2 mt-0.5">${message}</p>
                    ${actionUrl && actionUrl !== '#' ? `
                        <div class="mt-2.5">
                            <a href="${actionUrl}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline">
                                <span>View Details</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    ` : ''}
                </div>
                <button type="button" onclick="document.getElementById('${toastId}').remove()" class="absolute top-3 right-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1.5 rounded-lg transition-colors cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
            <!-- Countdown Progress Bar -->
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-slate-100 dark:bg-slate-800 overflow-hidden">
                <div class="h-full bg-emerald-500 transition-all linear" style="width: 100%; transition-duration: 7000ms;"></div>
            </div>
        `;

        container.appendChild(toast);

        // Trigger entrance animation
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-6', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
            const progress = toast.querySelector('.bg-emerald-500');
            if (progress) {
                setTimeout(() => { progress.style.width = '0%'; }, 50);
            }
        });

        // Auto remove after 7 seconds
        setTimeout(() => {
            if (document.getElementById(toastId)) {
                toast.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => toast.remove(), 300);
            }
        }, 7000);
    }

    // Initialize Pusher Connection
    try {
        const pusher = new Pusher('{{ $pusherKey }}', {
            cluster: '{{ $pusherCluster }}',
            forceTLS: true
        });

        @if($currentUser->role === 'admin')
            // Subscribe to admin global channel
            const adminChannel = pusher.subscribe('admin-notifications');
            adminChannel.bind('notification.created', function(data) {
                showNotificationToast(data);
            });
            adminChannel.bind('RealtimeNotification', function(data) {
                showNotificationToast(data);
            });
            adminChannel.bind('App\\Events\\RealtimeNotificationEvent', function(data) {
                showNotificationToast(data);
            });
        @endif

        // Subscribe to user individual channel
        const userChannel = pusher.subscribe('user-notifications-{{ $currentUser->id }}');
        userChannel.bind('notification.created', function(data) {
            showNotificationToast(data);
        });
        userChannel.bind('RealtimeNotification', function(data) {
            showNotificationToast(data);
        });
        userChannel.bind('App\\Events\\RealtimeNotificationEvent', function(data) {
            showNotificationToast(data);
        });

        // Global users channel
        const allUsersChannel = pusher.subscribe('all-users-notifications');
        allUsersChannel.bind('notification.created', function(data) {
            showNotificationToast(data);
        });
        allUsersChannel.bind('RealtimeNotification', function(data) {
            showNotificationToast(data);
        });
        allUsersChannel.bind('App\\Events\\RealtimeNotificationEvent', function(data) {
            showNotificationToast(data);
        });

    } catch (e) {
        console.warn('Pusher initialization error:', e);
    }
})();
</script>
@endif
@endauth
