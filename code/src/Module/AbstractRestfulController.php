<?php
namespace My\Module;

/**
 * Class AbstractRestfulController. Child of this class should handle request in the following way
 *
 * GET: /resource/id - get element of resource by id
 * GET: /resource - get collection of elements of resource, get all resources
 *
 * POST: /resource/id - update existing resource by id, return null if this resource does not exists
 * POST: /resource - add new resource
 *
 * PUT: /resource/id - Update existing resource by id, or add new resource with this id, or return null if it's not possible
 * PUT: /resource - update all resources
 *
 * DELETE: /resource/id - delete existing resource where by id, return null if this resource does not exists
 * DELETE: /resource - delete all resources
 *
 *
 * @package My\HttpFramework\Controller
 */
abstract class AbstractRestfulController extends AbstractController
{
    /**
     * @param $id
     */
    public function getAction($id)
    {
        if (is_null($id)) {
            $this->getCollectionAction();
        } else {
            $this->getElementAction($id);
        }
    }

    public function postAction($id)
    {
        if (is_null($id)) {
            $this->postCollectionAction();
        } else {
            $this->postElementAction($id);
        }
    }

    public function putAction($id)
    {
        if (is_null($id)) {
            $this->putCollectionAction();
        } else {
            $this->putElementAction($id);
        }
    }

    public function deleteAction($id)
    {
        if (is_null($id)) {
            $this->deleteCollectionAction();
        } else {
            $this->deleteElementAction($id);
        }
    }

    abstract protected function getElementAction($id);

    abstract protected function getCollectionAction();

    abstract protected function postElementAction($id);

    abstract protected function postCollectionAction();

    abstract protected function putElementAction($id);

    abstract protected function putCollectionAction();

    abstract protected function deleteElementAction($id);

    abstract protected function deleteCollectionAction();

}