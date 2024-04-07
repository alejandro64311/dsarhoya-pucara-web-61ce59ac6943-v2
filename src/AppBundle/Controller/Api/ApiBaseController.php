<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;

/**
 * Api Base Controller
 */
class ApiBaseController extends BaseController
{
    /**
     * serializedResponse function
     *
     * @param mixed $data
     * @param array $groups
     * @param integer $statusCode
     * @return Response
     */
    public function serializedResponse($data, $groups = [], $statusCode = 200) : Response
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        if (is_array($request->get('expand'))) {
            $groups = array_merge($groups, $request->get('expand'));
        } elseif (is_array($request->get('expand[]'))) {
            $groups = array_merge($groups, $request->get('expand[]'));
        }
        $serializer = $this->container->get('jms_serializer');

        if (is_array($groups) && count($groups)) {
            $response = new Response($serializer->serialize($data, 'json', SerializationContext::create()->setGroups($groups)), $statusCode);
        } else {
            $response = new Response($serializer->serialize($data, 'json', SerializationContext::create()), $statusCode);
        }
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
