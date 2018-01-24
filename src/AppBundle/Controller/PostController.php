<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\Validate;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Post controller.
 *
 * @Route("api/post")
 */
class PostController extends Controller
{
    /**
     * @ApiDoc(
     *  headers={
     *      {
     *          "name"="Authorization",
     *          "required"=true,
     *          "description"="Authorization key"
     *      }
     *  },
     *  description="Finds all post entity.",
     *  section="Post",
     *  output={"collection"=true, "collectionName"="Post", "class"="AppBundle\Entity"}
     * )
     *
     * @Route("/", name="post_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->findAll();

        $response = [];

        if(count($posts) === 0)
        {
            $response = [
                'code' => 1,
                'message' => 'no posts found',
                'error' => null,
                'result' => null
            ];

            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }

        $data = $this->get('jms_serializer')->serialize($posts, 'json');

        $response = [
            'code' => 0,
            'message' => 'success',
            'error' => null,
            'result' => json_decode($data)
        ];

        return new JsonResponse($response, 200);
    }

    /**
     * @ApiDoc(
     *  headers={
     *      {
     *          "name"="Authorization",
     *          "required"=true,
     *          "description"="Authorization key"
     *      }
     *  },
     *  description="Creates a new post entity.",
     *  requirements={
     *      {
     *          "name"="title",
     *          "dataType"="string",
     *          "requirement"="\d+",
     *          "description"="title's post"
     *      }
     *  },
     *  section="Post"
     * )
     *
     *
     * @Route("/", name="post_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $data = $request->getContent();
        $post = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Post', 'json');
        $validator = $this->get('app.validate');
        $error = $validator->validateRequest($post);

        if ($error) return new jsonResponse($error, Response::HTTP_BAD_REQUEST);

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        
        $response = [
            'code' => 0,
            'message' => 'Post created',
            'errors' => null,
            'result' => null
        ];

        return new JsonResponse($response, Response::HTTP_CREATED);
    }

    /**
     * @ApiDoc(
     *  headers={
     *      {
     *          "name"="Authorization",
     *          "required"=true,
     *          "description"="Authorization key"
     *      }
     *  },
     *  description="Finds and displays a post entity.",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="identifier of the post entity"
     *      }
     *  },
     *  section="Post",
     *  output={"collection"=false, "collectionName"="Post", "class"="AppBundle\Entity"}
     * )
     *
     * @Route("/{id}", name="post_show")
     * @Method("GET")
     */
    public function showAction(Post $post)
    {
        $response = [];
        if(!$post)
        {
            $response = [
                'code' => 1,
                'message' => 'post not found',
                'error' => null,
                'result' => null
            ];

            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }

        $data = $this->get('jms_serializer')->serialize($post, 'json');

        $response = [
            'code' => 0,
            'message' => 'success',
            'error' => null,
            'result' => json_decode($data)
        ];

        return new JsonResponse($response, 200);
    }

    /**
     * @ApiDoc(
     *  headers={
     *      {
     *          "name"="Authorization",
     *          "required"=true,
     *          "description"="Authorization key"
     *      }
     *  },
     *  description="Edit an existing post entity.",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="identifier of the post entity"
     *      }
     *  },
     *  section="Post"
     * )
     *
     * @Route("/{id}", name="post_edit")
     * @Method("PUT")
     */
    public function editAction(Request $request, Post $post)
    {
        $response = [];
        if(!$post)
        {
            $response = [
                'code' => 1,
                'message' => 'post not found',
                'error' => null,
                'result' => null
            ];

            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }

        $data = $request->getContent();
        $entity = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Post', 'json');

        $validator = $this->get('app.validate');
        $error = $validator->validateRequest($post);

        if ($error) return new jsonResponse($error, Response::HTTP_BAD_REQUEST);

        $post->setTitle($entity->getTitle());

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        
        $response = [
            'code' => 0,
            'message' => 'Post updated',
            'errors' => null,
            'result' => null
        ];

        return new JsonResponse($reponse, 200);
    }

    /**
     * @ApiDoc(
     *  headers={
     *      {
     *          "name"="Authorization",
     *          "required"=true,
     *          "description"="Authorization key"
     *      }
     *  },
     *  description="Delete a post entity.",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="identifier of the post entity"
     *      }
     *  },
     *  section="Post",
     *  output={"collection"=false, "collectionName"="Post", "class"="AppBundle\Entity"}
     * )
     * Deletes a post entity.
     *
     * @Route("/{id}", name="post_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Post $post)
    {
        $response = [];
        if(!$post)
        {
            $response = [
                'code' => 1,
                'message' => 'post not found',
                'error' => null,
                'result' => null
            ];

            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $response = [
            'code' => 0,
            'message' => 'post deleted',
            'error' => null,
            'result' => null
        ];

        return new JsonResponse($response, 200);
    }
}
