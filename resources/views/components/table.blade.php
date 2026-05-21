@props([
    'headers' => [],
    'striped' => true,
    'hover' => true,
    'empty' => false,
    'emptyMessage' => 'No records found in the system.'
])

@php
    $rowClasses = "transition-colors duration-150 border-b border-border-subtle";
    if ($striped) {
        $rowClasses .= " odd:bg-panel-bg even:bg-slate-50/40";
    } else {
        $rowClasses .= " bg-panel-bg";
    }
    if ($hover) {
        $rowClasses .= " hover:bg-slate-50";
    }
@endphp

<div class="w-full overflow-hidden border border-border-subtle rounded shadow-sm bg-panel-bg">
    <div class="w-full overflow-x-auto">
        <table class="w-full border-collapse text-left text-sm text-secondary">
            <thead class="bg-slate-50/80 border-b border-border-subtle select-none">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col" class="px-6 py-3.5 text-sm font-semibold text-primary uppercase tracking-wider">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            
            <tbody class="divide-y divide-border-subtle">
                @if($empty)
                    <tr>
                        <td colspan="{{ count($headers) }}" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <svg class="w-12 h-12 text-secondary/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.008 1.24l.885 1.77a2.25 2.25 0 002.007 1.24h1.98a2.25 2.25 0 002.007-1.24l.885-1.77a2.25 2.25 0 012.007-1.24h3.86m-18 0h18" />
                                </svg>
                                <p class="text-sm font-medium text-secondary/60 m-0">
                                    {{ $emptyMessage }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @else
                    {{ $slot }}
                @endif
            </tbody>
        </table>
    </div>
    
    @if(isset($pagination))
        <div class="px-6 py-4 border-t border-border-subtle bg-slate-50/50 flex items-center justify-between select-none">
            {{ $pagination }}
        </div>
    @endif
</div>
