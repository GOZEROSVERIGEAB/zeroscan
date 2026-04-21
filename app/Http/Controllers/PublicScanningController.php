<?php

namespace App\Http\Controllers;

use App\Models\Station;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class PublicScanningController extends Controller
{
    public function show(string $uuid)
    {
        $station = Station::where('public_uuid', $uuid)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.scan', ['station' => $station]);
    }

    public function qrCode(string $uuid)
    {
        $station = Station::where('public_uuid', $uuid)->firstOrFail();

        $url = route('public.scan', ['uuid' => $station->public_uuid]);

        $renderer = new ImageRenderer(
            new RendererStyle(400, 2),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $svg = $writer->writeString($url);

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => "inline; filename=\"station-{$station->id}-qr.svg\"",
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
