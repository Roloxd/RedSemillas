<?php
/*
* Multiple functions
*/
namespace App\Utils;

// use App\Repository\EntradaRepository;
// use App\Repository\Passport\PassportRepository;
// use App\Repository\Passport\PassportEnvasesRepository;
// use App\Repository\Salidas\SalidasRepository;
use App\Entity\Passport\Passport;
use App\Entity\Passport\PassportEnvases;
use App\Entity\Salidas\Salidas;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Translation\MessageCatalogueInterface;
use Symfony\Component\VarDumper\VarDumper;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Utilities extends AbstractController
{

	protected $translated;
	protected $message;
	protected $dir;
	protected $langArr;

	protected $salidas;
    protected $passport;
    protected $envases;
    protected $entradas;
	
	function __construct(
	    TranslatorInterface $translator,
        // SalidasRepository $salidasRepo,
        // PassportRepository $passportRepo,
        // PassportEnvasesRepository $envasesRepo,
        // EntradaRepository $entradaRepo,
        string $projectDir
    ){
		
		$this->translated = $translator;
		$this->dir = $projectDir;

        // $this->salidas = $salidasRepo;
        // $this->passport = $passportRepo;
        // $this->envases = $envasesRepo;
        // $this->entradas = $entradasRepo;

		// loads php language
		// and gets the array
		$file = $projectDir.'/translations/messages.es.php';
		$load  = include_once($file);
		$this->langArr = $load;
			
	}
	
	public function load( array $configs, ContainerBuilder $container)
	{
		$file = $$loader.'/translations/';

		$loader = new PhpFileLoader($container, new FileLocator($file));
		$loader->load('messages.es.php');
		$this->ff = $loader->load('messages.es.php');
		VarDumper::dump($this->ff);	
		
	}

    // Function for recurrent inputs
	public function rgcsField($label, $showLabel =  '', $class = 'rgcs__form-row'){
		
		$lang = $this->translated->trans($label);
		
		$isLabel = true;
		$isPlaceholder = true;
		
		if($showLabel == 'label'){
			$isLabel = true;
			$isPlaceholder = false;		
		}elseif($showLabel == 'both'){
			$isLabel = true;
			$isPlaceholder = true;	
		}elseif($showLabel == 'placeholder'){
			$isLabel = false;
			$isPlaceholder = true;	
		}else{
			$isLabel = false;
			$isPlaceholder = false;
		}
		
		$option = [
			'label'    => ($isLabel == true)? $lang : false,
			'attr'     => ['placeholder' => ($isPlaceholder == true)? $lang : false],
			'row_attr' => ['class' => $class],
			'required' => false,
		];
				
		return $option;
	}
	
	
	public function rgcsFields($label, $showLabel =  '', $class = 'rgcs__form-row', $other){
		
		$lang = $this->translated->trans($label);
		$isLabel = false;
		$isPlaceholder = true;
		
		if($showLabel == 'label'){
			$label = true;
			$placeholder = false;		
		}elseif($showLabel == 'both'){
			$label = true;
			$placeholder = true;	
		}elseif($showLabel == 'placeholder'){
			$label = false;
			$placeholder = true;	
		}else{
			$label = false;
			$placeholder = false;
		}
		
		$option = array('options' =>[
			'label'    => ($isLabel == true)? $label : false,
			'attr'     => ['placeholder' => ($isPlaceholder == true)? $label : false],
            'attr'     => ['name'=>'sfsfgd'],
			'row_attr' => ['class' => $class],
			'required' => false,
			]
		);
		array_merge($option['options'], array($other));
		
		return $option;
	}
	
	public function lang($string, $type = ''){
		if($type == ''){
		   return $this->translated->trans($string);  
	    }else {
		   return $this->translated->trans($string);  
		}   
	}
	
	// Load translation array into a array to use as variable
	// The key must be a number
	public function multiOptions($lang, $count = 20){
		//$mess = new MessageCatalogue('es');
		//VarDumper::dump($this->message);
		//VarDumper::dump($mess->getMetadata($lang));	
	    //VarDumper::dump($this->langArr[$lang]);

		$array = array();
		for($i = 0; $i<$count; $i++){
			$array[] =  self::lang($lang.'.'.$i);
		}
		return $array;
	}
	
	// converts message.es.php to array
	// Usefull to create select option lists
	public function langArray($lang, $count = 20){	
		
        $get = $this->langArr[$lang];
		$array = array();
		//VarDumper::dump($get);
		foreach($get as $key => $val){
			if($key != 'label' && $key != 'descr'){
				$array[] =  self::lang($lang.'.'.$key);
			}
			//VarDumper::dump($key.$val);	
		}
		return $array;
	}
	
	// Increment passport number
	public function incrementCodeNumber($code, $count, $prefix = null){

		if(strpos($code, '-')) {

            $getCode = explode('-', $code);

            $arr = [
                $getCode[0],
                str_pad($getCode[1] + 1, $count, "0", STR_PAD_LEFT)
            ];
            $setCode = implode('-', $arr);

            return $setCode;
        }

        return $prefix.'-0000';

	}
	
	// GET LAST PASSPORT number and convert
	public function setPassportNumber(){
		
		$em = $this->getDoctrine()->getManager();
		$number = $em->getRepository(Passport::class)
					 ->lastPassportNumber()
					 ->getNumeroPasaporte();

        $number = $this->passport->lastPassportNumber();

        // check if no entries
        if($number != null) {
            $number = $number->getNumeroPasaporte();
        }else{
            $number = '';
        }
		  
		$processed = self::incrementCodeNumber($number, 4, 'RGCS');
		//VarDumper::dump($processed);      

		return $processed; 		
	}
	
	public function setEnvaseNumber(){
		
        $number = $this->envases->lastSalidaNumber();

        // check if no entries
        if($number != null) {
            $number = $number->lastEnvaseNumber();
        }else{
            $number = '';
        }
		  
		$processed = self::incrementCodeNumber($number, 4, 'E');
		//VarDumper::dump($processed);      

		return $processed; 		
	}

	public function setSalidasNumber(){

        $number = $this->salidas->lastSalidaNumber();

        // check if no entries
        if($number != null) {
            $number = $number->getNumeroSalida();
        }else{
            $number = '';
        }
        //VarDumper::dump($number);

        $processed = self::incrementCodeNumber($number, 4, 'SAL');
        //VarDumper::dump($processed);

        return $processed;

    }

    public function setEntradasNumber(){

        $number = $this->entradas->lastEntradaNumber();

        // check if no entries
        if($number != null) {
            $number = $number->getCodigoEntrada();
        }else{
            $number = '';
        }
        //VarDumper::dump($number);

        $processed = self::incrementCodeNumber($number, 4, 'ENT');
        //VarDumper::dump($processed);

        return $processed;

    }
	
	
	
	
	

}