{{-- Barra superior com contactos e horário --}}
<div class="bg-topbar text-topbar-foreground py-2.5 text-sm hidden md:block border-b border-white/5">
    <div class="container mx-auto flex items-center justify-between px-4">
        <div class="flex items-center gap-8">
            <a href="mailto:mucuanha.chineva@gmail.com"
               class="flex items-center gap-2 opacity-70 hover:opacity-100 hover:text-accent transition-all duration-300 group">
                <div class="w-6 h-6 rounded-md bg-white/8 flex items-center justify-center group-hover:bg-accent/20 transition-colors">
                    <i data-lucide="mail" class="w-3 h-3"></i>
                </div>
                mucuanha.chineva@gmail.com
            </a>
            <a href="tel:+244929643510"
               class="flex items-center gap-2 opacity-70 hover:opacity-100 hover:text-accent transition-all duration-300 group">
                <div class="w-6 h-6 rounded-md bg-white/8 flex items-center justify-center group-hover:bg-accent/20 transition-colors">
                    <i data-lucide="phone" class="w-3 h-3"></i>
                </div>
                +244 929-643-510
            </a>
        </div>
        <div class="flex items-center gap-5">
            <span class="flex items-center gap-2 opacity-60">
                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                Seg - Sex: 8h00 - 18h00
            </span>
            <div class="h-4 w-px bg-white/15"></div>
            <div class="flex items-center gap-1.5">
                @foreach(['facebook', 'instagram', 'linkedin'] as $social)
                    <a href="#"
                       class="w-7 h-7 rounded-lg flex items-center justify-center opacity-50 hover:opacity-100 hover:bg-accent/20 hover:text-accent transition-all duration-300">
                        <i data-lucide="{{ $social }}" class="w-3.5 h-3.5"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
