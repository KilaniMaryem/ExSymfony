<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'todo')]
    public function index(Request $req): Response
    {   $session=$req->getSession();
        if(!$session->has('todos')){
            $todos=array(
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            );
            $session->set('todos',$todos);
            $this->addFlash('info','Le tableau vient d etre initialisé!');

        }
        return $this->render('todo/index.html.twig',);
    }
    #[Route('/todo/add/{cle}/{val}', name: 'todo.add')]
    public function add(Request $req,$cle,$val): Response
    {   $session=$req->getSession();
        if ($session->has('todos')){
            $todos=$session->get('todos');
            if (isset($todos[$cle])){
                $this->addFlash('error','La clé existe déjà!');
            }else{
                $todos[$cle]=$val;
                $session->set('todos',$todos);
                $this->addFlash('success','Le todo vient d etre ajouté!');
            }

        }else{
            $this->addFlash('error','Le tableau n est pas encore initialisé!');
        }
  return $this->redirectToRoute('todo');
    }

    #[Route('/todo/update/{cle}/{val}', name: 'todo.update')]
    public function update(Request $req,$cle,$val): Response
    {   $session=$req->getSession();
        if ($session->has('todos')){
            $todos=$session->get('todos');
            if (isset($todos[$cle])){
                $todos[$cle]=$val;
                $session->set('todos',$todos);
                $this->addFlash('success','Le todo vient d etre modifié!');
            }else{
                $this->addFlash('error','cette clé n existe pas!');
            }

        }else{
            $this->addFlash('error','Le tableau n est pas encore initialisé!');
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/delete/{cle}', name: 'todo.delete')]
    public function del(Request $req,$cle): Response
    {   $session=$req->getSession();
        if ($session->has('todos')){
            $todos=$session->get('todos');
            if (isset($todos[$cle])){
                unset ($todos[$cle]);
                $session->set('todos',$todos);
                $this->addFlash('success','Le todo vient d etre supprimé!');
            }else{
                $this->addFlash('error','cette clé n existe pas!');
            }

        }else{
            $this->addFlash('error','Le tableau n est pas encore initialisé!');
        }
        return $this->redirectToRoute('todo');
    }


    #[Route('/todo/reset', name: 'todo.reset')]
    public function reset(Request $req): Response
    {   $session=$req->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('todo');
    }









}
