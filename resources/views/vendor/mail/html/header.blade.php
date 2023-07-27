@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/images/misc_ui/Barbofus_Logo_Full.png'))) }}" class="header-logo" alt="{{ $slot }}">
</a>
</td>
</tr>
