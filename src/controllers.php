<?php

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Drs\DrsItem;
use Drs\DrsUser;
/**
 * Example homepage
 */

$app->match('/', function() use ($app) {
    $builder = $app['form.factory']->createBuilder('form');
    $form = $builder
    ->add('search', 'search')
    ->getForm();

    return $app['twig']->render('index.html.twig', array('search' => $form->createView()));
})->bind('homepage');

/**
 * Example login page.
 * 
 */
$app->match('/login', function(Request $request) use ($app) {
    $form = $app['form.factory']->createBuilder('form')
        ->add('username', 'text', array('label' => 'Username', 'data' => $app['session']->get('_security.last_username')))
        ->add('password', 'password', array('label' => 'Password'))
        ->getForm()
    ;

    return $app['twig']->render('login.html.twig', array(
        'form'  => $form->createView(),
        'error' => $app['security.last_error']($request),
    ));
})->bind('login');

/**
 * Example DB page
 */

$app->match('/doctrine', function() use ($app) {
    return $app['twig']->render(
        'doctrine.html.twig',
        array(
            'posts' => $app['db']->fetchAll('SELECT * FROM post')
        )
    );
})->bind('doctrine');

$app->match('/form', function(Request $request) use ($app) {

    $builder = $app['form.factory']->createBuilder('form');
    $choices = array('choice a', 'choice b', 'choice c');

    $form = $builder
        ->add(
            $builder->create('sub-form', 'form')
                ->add('subformemail1', 'email', array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Email()),
                    'attr'        => array('placeholder' => 'email constraints'),
                    'label'       => 'A custome label : ',
                ))
                ->add('subformtext1', 'text')
        )
        ->add('text1', 'text', array(
            'constraints' => new Assert\NotBlank(),
            'attr'        => array('placeholder' => 'not blank constraints')
        ))
        ->add('text2', 'text', array('attr' => array('class' => 'span1', 'placeholder' => '.span1')))
        ->add('text3', 'text', array('attr' => array('class' => 'span2', 'placeholder' => '.span2')))
        ->add('text4', 'text', array('attr' => array('class' => 'span3', 'placeholder' => '.span3')))
        ->add('text5', 'text', array('attr' => array('class' => 'span4', 'placeholder' => '.span4')))
        ->add('text6', 'text', array('attr' => array('class' => 'span5', 'placeholder' => '.span5')))
        ->add('text8', 'text', array('disabled' => true, 'attr' => array('placeholder' => 'disabled field')))
        ->add('textarea', 'textarea')
        ->add('email', 'email')
        ->add('integer', 'integer')
        ->add('money', 'money')
        ->add('number', 'number')
        ->add('password', 'password')
        ->add('percent', 'percent')
        ->add('search', 'search')
        ->add('url', 'url')
        ->add('choice1', 'choice',  array(
            'choices'  => $choices,
            'multiple' => true,
            'expanded' => true
        ))
        ->add('choice2', 'choice',  array(
            'choices'  => $choices,
            'multiple' => false,
            'expanded' => true
        ))
        ->add('choice3', 'choice',  array(
            'choices'  => $choices,
            'multiple' => true,
            'expanded' => false
        ))
        ->add('choice4', 'choice',  array(
            'choices'  => $choices,
            'multiple' => false,
            'expanded' => false
        ))
        ->add('country', 'country')
        ->add('language', 'language')
        ->add('locale', 'locale')
        ->add('timezone', 'timezone')
        ->add('date', 'date')
        ->add('datetime', 'datetime')
        ->add('time', 'time')
        ->add('birthday', 'birthday')
        ->add('checkbox', 'checkbox')
        ->add('file', 'file')
        ->add('radio', 'radio')
        ->add('password_repeated', 'repeated', array(
            'type'            => 'password',
            'invalid_message' => 'The password fields must match.',
            'options'         => array('required' => true),
            'first_options'   => array('label' => 'Password'),
            'second_options'  => array('label' => 'Repeat Password'),
        ))
        ->getForm()
    ;

    if ($request->isMethod('POST')) {
        $form->bind($request);
        if ($form->isValid()) {
            $app['session']->getFlashBag()->add('success', 'The form is valid');
        } else {
            $form->addError(new FormError('This is a global error'));
            $app['session']->getFlashBag()->add('info', 'The form is bind, but not valid');
        }
    }

    return $app['twig']->render('form.html.twig', array('form' => $form->createView()));
})->bind('form');

$app->match('/logout', function() use ($app) {
    $app['session']->clear();

    return $app->redirect($app['url_generator']->generate('homepage'));
})->bind('logout');

$app->get('/page-with-cache', function() use ($app) {
    $response = new Response($app['twig']->render('page-with-cache.html.twig', array('date' => date('Y-M-d h:i:s'))));
    $response->setTtl(10);

    return $response;
})->bind('page_with_cache');

/**
 * Error handling for page can't be found etc.
 * 
 */

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message, $code);
});

/**
 * browse controller
 */

$app->match('/browse', function() use ($app){
    $pid = "Something"; 

    return $app['twig']->render('browse.html.twig', array('pid' => $pid));
})->bind('browse');



/**
 * Advanced Search Controller
 */

$app->match('/search', function(Request $request) use ($app){
    $builder = $app['form.factory']->createBuilder('form');


    $form = $builder
        ->add('search', 'search', array(
            'label' => 'Keywords'
            ))
        ->add('operator', 'choice', array(
            'choices' => array('and', 'or'),
            'multiple' => False,
            'expanded' => false,
            'label' => 'Operator'
            ))
        ->add('search2', 'search')
        ->add('operator2', 'choice', array(
            'choices' => array('and', 'or'),
            'multiple' => False,
            'expanded' => false,
            ))
        ->getForm();

    if ($request->isMethod('POST')) {
        $form->bind($request);
        if ($form->isValid()) {
            d($request);

            $client = $app['solr'];
            $query = $client->createSelect();
            $query->setQuery($keywords);
            $query-> setRows(40);
            $resultset = $client -> select($query);
            $docset = $resultset -> getDocuments();
            //d($docset);
            return $app['twig']->render('search.html.twig', array('keywords' => $keywords, 'resultset' => $docset));
        } else {
            $form->addError(new FormError('This is a global error'));
            $app['session']->getFlashBag()->add('info', 'The form is bind, but not valid');
        }
    }

    return $app['twig']->render('form.html.twig', array('form' => $form->createView()));
})->bind('search');

/**
 *  Simple search with keywork
 */

$app->match('/search/{keywords}', function($keywords) use ($app){
    
    $client = $app['solr'];
    $query = $client->createSelect();
    $query->setQuery($keywords);
    $query-> setRows(40);
    $resultset = $client -> select($query);
    $docset = $resultset -> getDocuments();
    d($docset);
    return $app['twig']->render('search.html.twig', array('keywords' => $keywords, 'resultset' => $docset));
});


/**
 * view controller
 */

$app->match('/view/{pid}', function($pid) use ($app){
    $item = new DrsItem($pid, $app['solr']);

    
    
    $solr = $app['solr'];
    $repo = $app['drs.repo'];
    
    $item = $repo->getMedia($item, $solr);
    

    d($item);

    return $app['twig']->render('view.html.twig', array(
        'item' => $item,
        
        
    ));
})->bind('view'); 

/**
 *  MyDRS Controller.
 */

$app->match('/my-drs', function() use ($app){
    return "My DRS";
})->bind('my-drs');


/**
 * Add content to repository
 */
$app->get('/add-content', function() use($app){
    return "Add Content Path";
})->bind('add-content');


/**
 * Add collection to repository 
 */

$app->get('/add-collection', function() use ($app){
    return "Add collection path.";
})->bind('add-collection');


$app->get('/repo', function() use ($app){
    $item = new DrsItem('neu:120306', $app['solr']);
    d($item);
    $repo = $app['drs.repo'];
    
    d($repo->getMedia($item, $app['solr']));
    return $repo->getMedia($item, $app['solr']);
    

});

$app->get('/download/{pid}', function($pid) use ($app){
    $pid = "neu:120306";
    $type = "sdef:image_highres";
    $item = new DrsItem($pid, $app['solr']);
    $repo = $app['drs.repo'];
    $media = $repo -> getMedia($item, $app['solr']);
    $hires = $media->media[2]->mediaMethods['getHIGHRES'];
    return $hires;
});





$app->match('/my-account', function(Request $request) use ($app) {
    
    $user =  new DrsUser( 
     56100,
     "Library-Office Of The Director",
     "SC79",
     "Library",
     "Patrick Yott",
     "00000000@neu.edu",
     "Patrick",
     "northeastern:library:staff:rads;northeastern:library:drs;northeastern:drs:staff",
     "cn=staff,ou=drs,ou=grouper,ou=groups,dc=neu,dc=edu;cn=Staff,ou=Groups,dc=neu,dc=edu;cn=drs,ou=library,ou=grouper,ou=groups,dc=neu,dc=edu;cn=rads,ou=staff,ou=library,ou=grouper,ou=groups,dc=neu,dc=edu",
     000000000,
     "Yott",
     "staff"
     )
    ;


    
    


    $pid = 'neu:126874';
    
    
    $repo = $app['drs.repo'];
    d($repo);
    d($user);
    
    $item = $repo->buildDrsItem($pid);

    $item = $repo->buildDrsItemDc($item);
    //$item =$repo->buildDrsObjectMethod($item);
    d($repo->buildDrsObjectMethod($item));
    d($item);
    return $user; 
    
})->bind('my-account');


return $app;
