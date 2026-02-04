<footer class="bg-[#4A83FF] text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Logo e Instituições -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold mb-4">Parceiros</h3>
                <div class="flex gap-4">
                    <div class="bg-white rounded-lg p-3">
                        <img src="/images/fapemig-logo.png" alt="FAPEMIG" class="h-12 object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div style="display:none;" class="text-[#4A83FF] font-bold text-sm">FAPEMIG</div>
                    </div>
                    <div class="bg-white rounded-lg p-3">
                        <img src="/images/unimontes-logo.png" alt="Unimontes" class="h-12 object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div style="display:none;" class="text-[#4A83FF] font-bold text-sm">Unimontes</div>
                    </div>
                </div>
            </div>

            <!-- Links Úteis -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Links Úteis</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="https://www.fapemig.br" target="_blank" rel="noopener noreferrer" 
                           class="hover:text-blue-200 transition-colors flex items-center gap-2">
                            FAPEMIG
                            <i class="ph ph-arrow-square-out text-sm"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.fadenor.edu.br" target="_blank" rel="noopener noreferrer" 
                           class="hover:text-blue-200 transition-colors flex items-center gap-2">
                            FADENOR
                            <i class="ph ph-arrow-square-out text-sm"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.uab.unimontes.br" target="_blank" rel="noopener noreferrer" 
                           class="hover:text-blue-200 transition-colors flex items-center gap-2">
                            UNIMONTES
                            <i class="ph ph-arrow-square-out text-sm"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Menu -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Menu</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="hover:text-blue-200 transition-colors">Início</a></li>
                    <li><a href="{{ route('public.sinais') }}" class="hover:text-blue-200 transition-colors">Sinais</a></li>
                    <li><a href="{{ route('public.catalogo') }}" class="hover:text-blue-200 transition-colors">Catálogo</a></li>
                    <li><a href="{{ route('public.categorias') }}" class="hover:text-blue-200 transition-colors">Categorias</a></li>
                    <li><a href="{{ route('public.about') }}" class="hover:text-blue-200 transition-colors">Sobre</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white mt-8 pt-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} Plataforma Digital Libras+. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>
