<div x-data="{ tab: @entangle('activeTab') }">
    <x-slot name="header">Git Documentation</x-slot>

    <!-- Tabs -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm mb-6">
        <div class="flex border-b border-gray-100 dark:border-slate-700">
            <button @click="tab = 'gitflow'" :class="tab === 'gitflow' ? 'text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 dark:border-indigo-400' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'" class="px-6 py-3.5 text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Git Flow
            </button>
            <button @click="tab = 'commits'" :class="tab === 'commits' ? 'text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 dark:border-indigo-400' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'" class="px-6 py-3.5 text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                Conventional Commits
            </button>
        </div>
    </div>

    <!-- Git Flow Tab -->
    <div x-show="tab === 'gitflow'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="space-y-6">

            {{-- Visual Flow Diagram --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Branch Flow Overview
                </h2>

                {{-- Horizontal Flow --}}
                <div class="overflow-x-auto pb-4">
                    <div class="flex items-start gap-4 min-w-[900px]">
                        {{-- Step 1: Master --}}
                        <div class="flex flex-col items-center gap-2 w-40 flex-shrink-0">
                            <div class="w-full bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-300 dark:border-amber-700 rounded-xl p-4 text-center relative">
                                <span class="absolute top-1 left-1 w-6 h-6 bg-amber-500 text-white text-xs font-bold rounded-full flex items-center justify-center">1</span>
                                <p class="text-sm font-bold text-amber-800 dark:text-amber-300">Master</p>
                            </div>
                            <p class="text-[10px] text-gray-400 text-center">Production-ready code</p>
                        </div>

                        <svg class="w-6 h-6 text-gray-300 dark:text-gray-600 mt-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>

                        {{-- Step 2: Dev Branches --}}
                        <div class="flex flex-col gap-2 flex-shrink-0 w-56">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-300 dark:border-blue-700 rounded-xl p-3 text-center relative">
                                <span class="absolute top-1 left-1 w-6 h-6 bg-blue-500 text-white text-xs font-bold rounded-full flex items-center justify-center">2</span>
                                <p class="text-xs font-bold text-blue-800 dark:text-blue-300 mb-2">Development</p>
                                <div class="space-y-1.5">
                                    <div class="bg-green-100 dark:bg-green-900/30 rounded-lg px-2 py-1"><code class="text-[10px] text-green-700 dark:text-green-400">feature/[modul]/[name]</code></div>
                                    <div class="bg-green-100 dark:bg-green-900/30 rounded-lg px-2 py-1"><code class="text-[10px] text-green-700 dark:text-green-400">improvment/[modul]/[name]</code></div>
                                </div>
                            </div>
                            <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-300 dark:border-blue-700 rounded-xl p-3 text-center relative">
                                <p class="text-xs font-bold text-blue-800 dark:text-blue-300 mb-2">Hotfix</p>
                                <div class="bg-red-100 dark:bg-red-900/30 rounded-lg px-2 py-1"><code class="text-[10px] text-red-700 dark:text-red-400">hotfix/[modul]/[name]</code></div>
                            </div>

                            <svg class="w-6 h-6 text-gray-300 dark:text-gray-600 mx-auto mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>

                        </div>

                        <svg class="w-6 h-6 text-gray-300 dark:text-gray-600 mt-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>

                        {{-- Step 3: SIT --}}
                        <div class="flex flex-col items-center gap-2 w-40 flex-shrink-0">
                            <div class="w-full bg-yellow-50 dark:bg-yellow-900/20 border-2 border-yellow-300 dark:border-yellow-700 rounded-xl p-4 text-center relative">
                                <span class="absolute top-1 left-1 w-6 h-6 bg-yellow-500 text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                                <p class="text-sm font-bold text-yellow-800 dark:text-yellow-300">SIT</p>
                                <p class="text-[10px] text-yellow-600 dark:text-yellow-400">Testing environment</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="overflow-x-auto pb-4">
                    <div class="flex items-start gap-4 min-w-[900px]">
                        {{-- Step 4: Master --}}
                        <div class="flex flex-col items-center gap-2 w-40 flex-shrink-0">
                            <div class="w-full bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-300 dark:border-amber-700 rounded-xl p-4 text-center relative">
                                <span class="absolute top-1 left-1 w-6 h-6 bg-amber-500 text-white text-xs font-bold rounded-full flex items-center justify-center">4</span>
                                <p class="text-sm font-bold text-amber-800 dark:text-amber-300">Master</p>
                            </div>
                            <p class="text-[10px] text-gray-400 text-center">Production-ready code</p>
                        </div>

                        <svg class="w-6 h-6 text-gray-300 dark:text-gray-600 mt-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>

                        {{-- Step 5: Release --}}
                        <div class="flex flex-col items-center gap-2 w-52 flex-shrink-0">
                            <div class="w-full bg-pink-50 dark:bg-pink-900/20 border-2 border-pink-300 dark:border-pink-700 rounded-xl p-4 text-center relative">
                                <span class="absolute top-1 left-1 w-6 h-6 bg-pink-500 text-white text-xs font-bold rounded-full flex items-center justify-center">5</span>
                                <p class="text-sm font-bold text-pink-800 dark:text-pink-300">Release</p>
                                <div class="mt-2 bg-pink-100 dark:bg-pink-900/30 rounded-lg px-2 py-1"><code class="text-[10px] text-pink-700 dark:text-pink-400">release/[yyyy-mm-dd]-[modul]</code></div>
                            </div>
                        </div>

                        <svg class="w-6 h-6 text-gray-300 dark:text-gray-600 mt-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>

                        {{-- Step 6: Production --}}
                        <div class="flex flex-col items-center gap-2 w-40 flex-shrink-0">
                            <div class="w-full bg-emerald-50 dark:bg-emerald-900/20 border-2 border-emerald-300 dark:border-emerald-700 rounded-xl p-4 text-center relative">
                                <span class="absolute top-1 left-1 w-6 h-6 bg-emerald-500 text-white text-xs font-bold rounded-full flex items-center justify-center">6</span>
                                <p class="text-sm font-bold text-emerald-800 dark:text-emerald-300">PRODUCTION</p>
                            </div>
                        </div>

                        <svg class="w-6 h-6 text-gray-300 dark:text-gray-600 mt-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>

                        {{-- Step 7: Master --}}
                        <div class="flex flex-col items-center gap-2 w-40 flex-shrink-0">
                            <div class="w-full bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-300 dark:border-amber-700 rounded-xl p-4 text-center relative">
                                <span class="absolute top-1 left-1 w-6 h-6 bg-amber-500 text-white text-xs font-bold rounded-full flex items-center justify-center">7</span>
                                <p class="text-sm font-bold text-amber-800 dark:text-amber-300">Master</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="flex flex-wrap gap-4 mt-4 pt-4 border-t border-gray-100 dark:border-slate-700">
                    <div class="flex items-center gap-2"><div class="w-4 h-4 rounded bg-amber-200 dark:bg-amber-800 border border-amber-400"></div><span class="text-xs text-gray-500">Environment</span></div>
                    <div class="flex items-center gap-2"><div class="w-4 h-4 rounded bg-blue-200 dark:bg-blue-800 border border-blue-400"></div><span class="text-xs text-gray-500">Action</span></div>
                    <div class="flex items-center gap-2"><div class="w-4 h-4 rounded bg-green-200 dark:bg-green-800 border border-green-400"></div><span class="text-xs text-gray-500">Branch Name Format</span></div>
                </div>
            </div>

            {{-- Branch Naming Convention --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Branch Naming Convention</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead><tr class="bg-gray-50 dark:bg-slate-900/50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Format</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Example</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
                        </tr></thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            <tr><td class="px-4 py-3"><span class="px-2 py-1 text-xs font-medium rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">Feature</span></td><td class="px-4 py-3"><code class="text-xs text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-1 rounded">feature/[modul]/[name]</code></td><td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400"><code>feature/ROPA/add-export</code></td><td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400">New features</td></tr>
                            <tr><td class="px-4 py-3"><span class="px-2 py-1 text-xs font-medium rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">Improvement</span></td><td class="px-4 py-3"><code class="text-xs text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-1 rounded">improvment/[modul]/[name]</code></td><td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400"><code>improvment/DPIA/ui-revamp</code></td><td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400">Enhancements to existing features</td></tr>
                            <tr><td class="px-4 py-3"><span class="px-2 py-1 text-xs font-medium rounded-lg bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400">Hotfix</span></td><td class="px-4 py-3"><code class="text-xs text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-1 rounded">hotfix/[modul]/[name]</code></td><td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400"><code>hotfix/GAP/fix-login</code></td><td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400">Critical production bug fixes</td></tr>
                            <tr><td class="px-4 py-3"><span class="px-2 py-1 text-xs font-medium rounded-lg bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400">Release</span></td><td class="px-4 py-3"><code class="text-xs text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-1 rounded">release/[yyyy-mm-dd]-[modul]</code></td><td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400"><code>release/2026-05-10-ROPA</code></td><td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400">Release preparation branches</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Modules --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Available Modules</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach(['GAP', 'ROPA', 'DPIA', 'DISCOVERY', 'CONSCENT_MNGMT', 'COOKIE_MNGMT', 'DSR', 'ERP', 'TPRM', 'DBM','MYPRIVASIMU', 'NOTIF', 'AUTH', 'CORE','SECURITY','UTILITY'] as $module)
                        <div class="bg-gray-50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-xl px-3 py-2.5 text-center">
                            <span class="text-xs font-bold text-gray-800 dark:text-gray-200">{{ $module }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Workflow Steps --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Workflow Steps</h2>
                <div class="space-y-4">
                    @php $steps = [
                        ['num' => '1', 'title' => 'Master Branch', 'desc' => 'Branch utama yang berisi production-ready code. Semua branch dibuat dari Master.', 'color' => 'amber'],
                        ['num' => '2', 'title' => 'Development Branches', 'desc' => 'Developer membuat branch feature/, improvment/, atau hotfix/ dari Master untuk mengerjakan task.', 'color' => 'blue'],
                        ['num' => '3', 'title' => 'SIT (System Integration Test)', 'desc' => 'Branch Development/Hotfix di-merge ke SIT untuk testing. QA melakukan testing di environment SIT.', 'color' => 'yellow'],
                        ['num' => '4', 'title' => 'Release Branch', 'desc' => 'Setelah testing selesai, buat release dari branch master dengan format release/[yyyy-mm-dd]-[modul]. Branch Development/Hotfix di-merge ke branch release untuk persiapan deploy.', 'color' => 'pink'],
                        ['num' => '5', 'title' => 'Production', 'desc' => 'Release branch di-merge ke PRODUCTION dan di-deploy ke Production. Tag version dibuat di Master.', 'color' => 'emerald'],
                    ]; @endphp
                    @foreach($steps as $step)
                        <div class="flex gap-4 items-start">
                            <div class="w-8 h-8 rounded-full bg-{{ $step['color'] }}-500 text-white text-sm font-bold flex items-center justify-center flex-shrink-0">{{ $step['num'] }}</div>
                            <div><h4 class="text-sm font-semibold text-gray-800 dark:text-white">{{ $step['title'] }}</h4><p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $step['desc'] }}</p></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Conventional Commits Tab -->
    <div x-show="tab === 'commits'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="space-y-6">

            {{-- Format --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Commit Message Format</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Based on <a href="https://www.conventionalcommits.org/en/v1.0.0/" target="_blank" class="text-indigo-600 dark:text-indigo-400 underline">Conventional Commits v1.0.0</a></p>
                <div class="bg-slate-900 rounded-xl p-5 font-mono text-sm">
                    <span class="text-emerald-400">&lt;type&gt;</span><span class="text-yellow-400">[optional scope]</span><span class="text-white">: </span><span class="text-sky-400">&lt;description&gt;</span>
                    <br><br>
                    <span class="text-gray-500">[optional body]</span>
                    <br><br>
                    <span class="text-gray-500">[optional footer(s)]</span>
                </div>
            </div>

            {{-- Types --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Commit Types</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @php $types = [
                        ['type' => 'feat', 'desc' => 'Fitur baru', 'color' => 'emerald', 'semver' => 'MINOR'],
                        ['type' => 'fix', 'desc' => 'Perbaikan bug', 'color' => 'red', 'semver' => 'PATCH'],
                        ['type' => 'docs', 'desc' => 'Perubahan pada dokumentasi saja', 'color' => 'blue', 'semver' => '-'],
                        ['type' => 'style', 'desc' => 'Perubahan gaya kode (formatting, titik koma, dll)', 'color' => 'purple', 'semver' => '-'],
                        ['type' => 'refactor', 'desc' => 'Perubahan kode yang bukan perbaikan bug maupun fitur baru', 'color' => 'amber', 'semver' => '-'],
                        ['type' => 'perf', 'desc' => 'Perubahan kode yang meningkatkan performa', 'color' => 'orange', 'semver' => '-'],
                        ['type' => 'test', 'desc' => 'Menambah atau memperbaiki test', 'color' => 'cyan', 'semver' => '-'],
                        ['type' => 'build', 'desc' => 'Perubahan pada sistem build atau dependensi', 'color' => 'gray', 'semver' => '-'],
                        ['type' => 'ci', 'desc' => 'Perubahan pada konfigurasi atau script CI', 'color' => 'indigo', 'semver' => '-'],
                        ['type' => 'chore', 'desc' => 'Perubahan lain yang tidak mengubah src atau test', 'color' => 'slate', 'semver' => '-'],
                        ['type' => 'revert', 'desc' => 'Membatalkan commit sebelumnya', 'color' => 'pink', 'semver' => '-'],
                    ]; @endphp
                    @foreach($types as $t)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-700">
                            <code class="px-2.5 py-1 rounded-lg text-xs font-bold bg-{{ $t['color'] }}-100 dark:bg-{{ $t['color'] }}-900/30 text-{{ $t['color'] }}-700 dark:text-{{ $t['color'] }}-400 flex-shrink-0">{{ $t['type'] }}</code>
                            <div class="flex-1 min-w-0"><p class="text-xs text-gray-700 dark:text-gray-300">{{ $t['desc'] }}</p></div>
                            @if($t['semver'] !== '-')
                                <span class="text-[10px] font-medium text-gray-400 bg-gray-100 dark:bg-slate-800 px-1.5 py-0.5 rounded flex-shrink-0">{{ $t['semver'] }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Examples --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Examples</h2>
                <div class="space-y-4">
                    @php $examples = [
                        ['title' => 'Simple feature', 'code' => 'feat: add user export functionality'],
                        ['title' => 'Feature with scope', 'code' => 'feat(ROPA): add data processing report'],
                        ['title' => 'Bug fix', 'code' => 'fix(GAP): resolve login timeout issue'],
                        ['title' => 'Breaking change with !', 'code' => 'feat(api)!: change authentication to OAuth2'],
                        ['title' => 'Docs update', 'code' => 'docs: update API documentation for v2'],
                        ['title' => 'With body and footer', 'code' => "fix(DPIA): prevent race condition in assessment\n\nIntroduce a request lock to prevent duplicate\nassessments from being created simultaneously.\n\nRefs: #234"],
                    ]; @endphp
                    @foreach($examples as $ex)
                        <div>
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1.5">{{ $ex['title'] }}</p>
                            <pre class="bg-slate-900 rounded-xl px-4 py-3 text-sm text-emerald-400 font-mono overflow-x-auto whitespace-pre-wrap">{{ $ex['code'] }}</pre>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Rules --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Key Rules</h2>
                <div class="space-y-3">
                    @php $rules = [
                        'Commit WAJIB diawali dengan type (feat, fix, dll.) diikuti tanda titik dua dan spasi.',
                        'Scope BOLEH ditambahkan setelah type dalam tanda kurung, contoh: feat(ROPA):',
                        'Deskripsi WAJIB ditulis langsung setelah tanda titik dua dan spasi.',
                        'Body yang lebih panjang BOLEH ditambahkan setelah satu baris kosong dari deskripsi.',
                        'Breaking changes WAJIB ditandai dengan tanda ! sebelum : atau sebagai footer BREAKING CHANGE:',
                        'Type selain feat dan fix BOLEH digunakan (docs, style, refactor, perf, test, dll.).',
                    ]; @endphp
                    @foreach($rules as $i => $rule)
                        <div class="flex gap-3 items-start">
                            <span class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-bold flex items-center justify-center flex-shrink-0">{{ $i + 1 }}</span>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $rule }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
