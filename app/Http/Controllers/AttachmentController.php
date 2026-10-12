<?php

namespace App\Http\Controllers;

use App\Actions\Attachments\AttachmentPath;
use App\Actions\Attachments\AuthorizeAttachment;
use App\Actions\Attachments\DeleteAttachments;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AttachmentController extends Controller
{
    public function show(Request $request, int $attachment, AuthorizeAttachment $authorize, AttachmentPath $paths)
    {
        $file = Attachment::findOrFail($attachment);
        $authorize->handle($request->user(), $file);
        $path = $paths->handle($file);
        abort_unless($path, 404);
        $mime = mime_content_type($path);
        if (in_array($mime, ['image/jpeg', 'image/png', 'application/pdf'], true)) {
            return response()->file($path, ['Content-Type' => $mime, 'X-Content-Type-Options' => 'nosniff',
                'Content-Security-Policy' => "sandbox; default-src 'none'", 'Cache-Control' => 'no-store'])->setPrivate();
        }
        $response = response()->download($path, basename($file->original_name ?: $path))->setPrivate();
        $response->headers->addCacheControlDirective('no-store');
        return $response;
    }
    public function destroy(Request $request, int $attachment, AuthorizeAttachment $authorize, DeleteAttachments $delete)
    {
        $file = Attachment::findOrFail($attachment);
        $authorize->handle($request->user(), $file, true);
        $delete->handle($file->attachable, $file->id);
        return redirect()->back()->with('success', 'Attachment deleted.');
    }
}
