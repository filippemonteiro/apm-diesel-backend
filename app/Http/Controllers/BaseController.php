<?php
namespace App\Http\Controllers;

use Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller {

    protected $entityManager;
    protected $repository;
    protected $services;
    protected $validator;
    protected $entity;
    protected $extractDataRequest;
    
    
    public function index(Request $request) {
        try {
            $filtro = $this->extractDataRequest->searchDataFilter($request);
            $informacoesDeOrdenacao = $this->extractDataRequest->searchDataOrder($request);
            [$paginaAtual, $itensPorPagina] = $this->extractDataRequest->searchDataPagination($request);
            $repository = $this->repository;
            $search = false;
            
            if(method_exists($repository, 'search')) {
                $search = true;
                $data = $this->repository->search(
                    $filtro,
                    $informacoesDeOrdenacao,
                    $itensPorPagina,
                    ($paginaAtual - 1) * $itensPorPagina
                );
            } else {
                $data = $this->repository->findBy(
                    $filtro,
                    $informacoesDeOrdenacao,
                    $itensPorPagina,
                    ($paginaAtual - 1) * $itensPorPagina
                );   
            }
            
            $total = $this->repository->getPagination();
            $paginate = $this->extractDataRequest->paginate($request, $total, $itensPorPagina, $search);
            $paginate['data'] = $data;
            return new JsonResponse(['data' => $paginate], 200);
        } catch(Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }
        
    }

    public function show($id) {
        $data = $this->services->show($id);
        return new JsonResponse(['data' => $data], Response::HTTP_ACCEPTED);
    }
    
    public function create(Request $request) {
        try {
            $this->getDoctrine()->getConnection()->beginTransaction();

            $params = $request->getContent() ? json_decode($request->getContent(), true) : $_POST;
            $this->entity = $this->services->loadObjects($this->services->entity, $params);
            $validation = $this->validator->validate($params);

            if ($validation->isValid()) {
                $this->services->beforeCreateData($params);
                $this->entity = $this->services->beforeCreateSanitizeData($this->entity);
                $this->entityManager->persist($this->entity);
                $this->entityManager->flush();
                
                $this->services->afterCreateData($params, $this->entity->getId(), $this->entityManager);
                $this->getDoctrine()->getConnection()->commit();
                return new JsonResponse(['message' => 'Registro salvo com sucesso.'], Response::HTTP_ACCEPTED);
            }
            return new JsonResponse(['errors' => $validation->getErrors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }catch(Exception $e) {
            $this->getDoctrine()->getConnection()->rollBack();
            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update($id, Request $request) {   
        try {
            $this->getDoctrine()->getConnection()->beginTransaction();
            
            $this->entity = $this->services->find($id);
            $params = $request->toArray();
            
            $this->entity = $this->services->loadObjects($this->entity, $params);
            $validation = $this->validator->validate($params);

            if ($validation->isValid()) {
                $this->services->beforeUpdateData($this->entity);
                
                $this->entityManager->persist($this->entity);
                $this->entityManager->flush();
                $this->services->afterUpdateData($params, $this->entity->getId(), $this->entityManager);

                $this->getDoctrine()->getConnection()->commit();
                return $this->json(['message' => 'Registro atualizado com sucesso.'], Response::HTTP_ACCEPTED);
            }
            return new JsonResponse(['errors' => $validation->getErrors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch(Exception $e) {
            $this->getDoctrine()->getConnection()->rollBack();
            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }

    public function delete($id) {
        try {
            $data = $this->repository->find($id);
            $this->services->beforeDataDelete($data);
            $this->entityManager->remove($data);
            $this->entityManager->flush();
            
            return $this->json(['message' => 'Registro removido com sucesso.'], Response::HTTP_ACCEPTED);
        } catch(Exception $e) {
            return $this->json(['message' => 'Não foi possível remover este registro. '.$e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
        
    }

    public function getParams($request) {
        $params = $request->getContent() ? json_decode($request->getContent(), true) : $_POST;
        return $params;
    }

    public function response($data, $status = 200) {
        return new JsonResponse($data, $status);
    }

}