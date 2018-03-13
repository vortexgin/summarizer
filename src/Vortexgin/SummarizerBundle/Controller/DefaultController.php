<?php

namespace Vortexgin\SummarizerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends Controller
{

    /**
     * @ApiDoc(
     *      section="Tools",
     *      resource="Summarizer",
     *      description="Summarize sentence",
     *      parameters={
     *          {"name"="sentence", "dataType"="string", "required"=true, "description"="Sentence"},
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *          400="Bad request",
     *          500="System error",
     *      }
     * )
     */
    public function analyzeAction(Request $request)
    {
        try{
            $post = $request->request->all();

            if (!array_key_exists('sentence', $post) || empty($post['sentence'])) {
                return new JsonResponse(
                    array(
                        'message' => 'Please insert sentence',
                        'success' => false,
                        'timestamp' => new \DateTime()
                    ), 400
                );
            }

            /* @var $summarizerManager \Vortexgin\SummarizerBundle\Manager\SummarizerManager */
            $summarizerManager = $this->container->get('vortexgin.summarizer.manager');

            $return = $summarizerManager->analyze($post['sentence']);

            return new JsonResponse($return, 200);
        }catch(\Exception $e){
            $this->container->get('logger')->error(sprintf($e->getMessage()));
            return new JsonResponse(
                array(
                    'message' => 'Analyze failed, Please try again later',
                    'success' => false,
                    'timestamp' => new \DateTime()
                ), 412
            );
        }
    }

    /**
     * @ApiDoc(
     *      section="Tools",
     *      resource="Summarizer",
     *      description="Summarize URL",
     *      parameters={
     *          {"name"="url", "dataType"="string", "required"=true, "description"="url"},
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *          400="Bad request",
     *          500="System error",
     *      }
     * )
     */
    public function analyzeUrlAction(Request $request)
    {
        try{
            $post = $request->request->all();

            if (!array_key_exists('url', $post) || empty($post['url'])) {
                return new JsonResponse(
                    array(
                        'message' => 'Please insert url',
                        'success' => false,
                        'timestamp' => new \DateTime()
                    ), 400
                );
            }

            /* @var $summarizerManager \Vortexgin\SummarizerBundle\Manager\SummarizerManager */
            $summarizerManager = $this->container->get('vortexgin.summarizer.manager');

            $return = $summarizerManager->analyzeUrl($post['url']);

            return new JsonResponse($return, 200);
        }catch(\Exception $e){
            $this->container->get('logger')->error(sprintf($e->getMessage()));
            return new JsonResponse(
                array(
                    'message' => 'Analyze failed, Please try again later',
                    'success' => false,
                    'timestamp' => new \DateTime()
                ), 412
            );
        }
    }
}
