<?php
namespace Said\Projet4blog\controller\frontend;

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/ConnectManager.php');

class ControllerFront{


  public function listPosts()
  {
        $postManager = new \Said\Projet4blog\Model\PostManager();; // Création d'un objet
        $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet
        require('view/frontend/listPostsView.php');

      }


      public function post()
      {
        $postManager = new \Said\Projet4blog\Model\PostManager();;
        $commentManager = new \Said\Projet4blog\Model\CommentManager();

        $post = $postManager->getPost($_GET['id']);
        $comments = $commentManager->getComments($_GET['id']);


        require('view/frontend/postView.php');
        
      }

      public function addComment($postId, $authorId, $comment)
      {	
      	$spaceVerif = trim($comment);
      	if (empty($spaceVerif)) {
          echo 'le commentaire ne peut être posté vide';
        }else{
          $commentManager = new \Said\Projet4blog\Model\CommentManager();

          $toEmpty = trim($comment);
          $affectedLines = $commentManager->postComment($postId, $authorId, $toEmpty);

          if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');

          }else{
            header('Location: index.php?action=post&id=' . $postId);
          }
        }
      }


    public function toConnect(){ //page de connexion


      require('view/frontend/connectView.php');

    }

    public function connect($pass,$pseudo){

      $connectManager = new \Said\Projet4blog\Model\ConnectManager();

      
      $authentificationtest = $connectManager->connexion($pass, $pseudo);
      

      if($authentificationtest){
        return header('Location: ./index.php');
           
      }

      require('view/frontend/connectView.php');
    }

    public function toRegister(){

      require('view/frontend/registerView.php');

    }

    public function register($pseudo,$pass){

      $connectManager = new \Said\Projet4blog\Model\ConnectManager();

      $registerSet= $connectManager->registering($pseudo,$pass);

      if($registerSet){
        header('Location: ./index.php?action=registConf');
      }

      require('view/frontend/registConfirmView.php');
    }


    public function signal($postId,$id){

      $commentManager = new \Said\Projet4blog\Model\CommentManager();
      $report = $commentManager->reportComm($id);
      
      header('Location: ./index.php?action=post&id=' . $postId);
      
    }

  }
