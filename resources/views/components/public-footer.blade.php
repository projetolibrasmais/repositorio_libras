<footer class="bg-brand-600 text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Logo e Instituições -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold mb-4">Parceiros</h3>
                <div class="flex gap-4">
                    <div class="bg-white rounded-lg p-3 flex items-center justify-center">
                        <img src="/images/asmoc.png" alt="ASMOC" class="w-20 object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div style="display:none;" class="text-[#4A83FF] font-bold text-sm">ASMOC</div>
                    </div>
                    <div class="bg-white rounded-lg p-3 flex items-center justify-center">
                        <img src="/images/cead.png" alt="CEAD" class="w-20 object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div style="display:none;" class="text-[#4A83FF] font-bold text-sm">CEAD</div>
                    </div>
                    <div class="bg-white rounded-lg p-3 flex items-center justify-center">
                        <img src="/images/fapemig.png" alt="FAPEMIG" class="w-20 object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div style="display:none;" class="text-[#4A83FF] font-bold text-sm">FAPEMIG</div>
                    </div>
                </div>
            </div>

            <!-- Links Úteis -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Links Úteis</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="https://signbank.libras.ufsc.br/pt" target="_blank" rel="noopener noreferrer" 
                           class="hover:text-brand-100 transition-colors flex items-center gap-2">
                            SignBank - UFSC
                            <i class="ph ph-arrow-square-out text-sm"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.sign-lang.uni-hamburg.de/lr/compendium/index.html" target="_blank" rel="noopener noreferrer" 
                           class="hover:text-brand-100 transition-colors flex items-center gap-2">
                            Sign Language Dataset Compendium
                            <i class="ph ph-arrow-square-out text-sm"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://sldict.korean.go.kr/front/main/main.do" target="_blank" rel="noopener noreferrer" 
                           class="hover:text-brand-100 transition-colors flex items-center gap-2">
                            Sign Language Dictionary - Coreia
                            <i class="ph ph-arrow-square-out text-sm"></i>
                        </a>
                    </li>
                    
                </ul>
            </div>

            <!-- Menu -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Menu</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-100 transition-colors">Início</a></li>
                    <li><a href="{{ route('public.sinais') }}" class="hover:text-brand-100 transition-colors">Sinais</a></li>
                    <li><a href="{{ route('public.catalogo') }}" class="hover:text-brand-100 transition-colors">Catálogo</a></li>
                    <li><a href="{{ route('public.categorias') }}" class="hover:text-brand-100 transition-colors">Categorias</a></li>
                    <li><a href="{{ route('public.about') }}" class="hover:text-brand-100 transition-colors">Sobre</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white mt-8 pt-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} Plataforma Digital Libras+. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>
