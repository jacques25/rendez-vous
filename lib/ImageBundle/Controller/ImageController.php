<?php

namespace Jacques\ImageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @author Benoit Jouhaud <bjouhaud@prestaconcept.net>
 */
class ImageController extends AbstractController
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function urlToBase64Action(Request $request)
    {
        $image = file_get_contents($request->request->get('url'));
        $imageInfo = getimagesizefromstring($image);
        $mimeType = false !== $imageInfo ? $imageInfo['mime'] : 'image/jpeg';
        $base64 = sprintf('data:' . $mimeType . ';base64,%s', base64_encode($image));

        return new JsonResponse([
            'base64' => $base64,
        ]);
    }
}
