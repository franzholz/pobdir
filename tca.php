<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_pobdir_entry'] = Array (
	'ctrl' => $TCA['tx_pobdir_entry']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'hidden,starttime,endtime,name,street,zip,city,tel,fax,mobil,email,www,profile,image,category,map,description,features,price,priceinfo,stars,capacity,ads,detail,belongsto,do_not_filter,mindestaufenthalt,pdf_info'
	),
	'feInterface' => $TCA['tx_pobdir_entry']['feInterface'],
	'columns' => Array (
		'hidden' => Array (		
			'exclude' => 1,	
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.hidden',
			'config' => Array (
				'type' => 'check',
				'default' => '0'
			)
		),
		'starttime' => Array (		
			'exclude' => 1,	
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.starttime',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'default' => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => Array (		
			'exclude' => 1,	
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.endtime',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'checkbox' => '0',
				'default' => '0',
				'range' => Array (
					'upper' => mktime(0,0,0,12,31,2020),
					'lower' => mktime(0,0,0,date('m')-1,date('d'),date('Y'))
				)
			)
		),
		'name' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.name',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'street' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.street',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'zip' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.zip',		
			'config' => Array (
				'type' => 'input',	
				'size' => '5',	
				'max' => '5',
			)
		),
		'city' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.city',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'tel' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.tel',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'fax' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.fax',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'mobil' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.mobil',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'email' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.email',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',	
			)
		),
		'www' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.www',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'profile' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.profile',		
			'config' => Array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'image' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.image',		
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'gif,png,jpeg,jpg',	
				'max_size' => 1000,	
				'uploadfolder' => 'uploads/tx_pobdir',
				'show_thumbs' => 1,	
				'size' => 5,	
				'minitems' => 0,
				'maxitems' => 5,
				'autoSizeMax' => 40,
			)
		),
		'category' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.category',		
			'config' => Array (
				'type' => 'select',	
				'foreign_table' => 'tx_pobdir_category',	
				'foreign_table_where' => 'AND tx_pobdir_category.pid=###CURRENT_PID### ORDER BY tx_pobdir_category.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'map' => Array (
    	'exclude' => 0,
    	'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.map',
    	'config' => Array (
    		'type' => 'input',
    		'size' => '30'
    	)
    ),
    
    'description' => Array (
    	'exclude' => 0,
    	'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.description',
    	'config' => Array (
    		'type' => 'text',
    		'cols' => '30',
    		'rows' => '5',
    	)
    ),
    
    'features' => Array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.features',		
			'config' => Array (
				'type' => 'select',	
				'foreign_table' => 'tx_pobdir_feature',	
				'foreign_table_where' => 'ORDER BY tx_pobdir_feature.name',	
				'size' => 15,	
				'minitems' => 0,
				'maxitems' => 50,
			)
		),
    
    'price' => Array (
    	'exclude' => 0,
    	'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.price',
    	'config' => Array (
    		'type' => 'text',
    		'cols' => '30',
    		'rows' => '5',
    	)
    ),
    
    'priceinfo' => Array (
    	'exclude' => 0,
    	'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.priceinfo',
    	'config' => Array (
    		'type' => 'text',
    		'cols' => '30',
    		'rows' => '5',
    	)
    ),
    'stars' => Array (
    	'exclude' => 0,
    	'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.stars',
    	'config' => Array (
    		'type' => 'select',
    		 'items' => Array (
           Array('', '0'),
           Array('1 Stern', '1'),
           Array('2 Sterne', '2'),
           Array('3 Sterne', '3'),
           Array('4 Sterne', '4'),
           Array('5 Sterne', '5'),
         ),    		
    		 //'eval' => 'int',                                       
         //'range' => array('lower' => 0,'upper' => 5),
    	)
    ),
    'capacity' => Array (
    	'exclude' => 0,
    	'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.capacity',
    	'config' => Array (
    		'type' => 'select',
    		 'items' => Array (
           Array('', '0'),
           Array('1', '1'),
           Array('2', '2'),
           Array('3', '3'),
           Array('4', '4'),
           Array('5', '5'),
           Array('6', '6'),
           Array('7', '7'),
           Array('8', '8'),
           Array('9', '9'),
           Array('10', '10'),
           Array('11', '11'),
           Array('12', '12'),
           Array('13', '13'),
           Array('14', '14'),
           Array('15', '15'),
           Array('16', '16'),
           Array('17', '17'),
           Array('18', '18'),
           Array('19', '19'),
           Array('20', '20'),
           Array('21', '21'),
           Array('22', '22'),
           Array('23', '23'),
           Array('24', '24'),
           Array('25', '25'),
           Array('26', '26'),
           Array('27', '27'),
           Array('28', '28'),
           Array('29', '29'),
           Array('30', '30'),
           Array('31', '31'),
           Array('32', '32'),
           Array('33', '33'),
           Array('34', '34'),
         ),    		
    		 //'eval' => 'int',                                       
         //'range' => array('lower' => 0,'upper' => 5),
    	)
    ),
    'ads' => Array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_ad.ad',		
			'config' => Array (
				'type' => 'select',	
				'foreign_table' => 'tx_pobdir_ad',	
				'foreign_table_where' => 'ORDER BY tx_pobdir_ad.name',	
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 50,
			)
		),
		'detail' => Array (		
			'exclude' => 1,	
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.detail',
			'config' => Array (
				'type' => 'check',
				'default' => '1'
			)
		),
		'belongsto' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.belongsto',		
			'config' => Array (
				'type' => 'select',	
				'foreign_table' => 'fe_users',	
				'foreign_table_where' => 'ORDER BY fe_users.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),		
		'do_not_filter' => Array (		
			'exclude' => 1,	
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.do_not_filter',
			'config' => Array (
				'type' => 'check',
				'default' => '1'
			)
		),		
		'mindestaufenthalt' => Array (
    	'exclude' => 0,
    	'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.mindestaufenthalt',
    	'config' => Array (
    		'type' => 'select',
    		 'items' => Array (
           Array('', '0'),
           Array('1', '1'),
           Array('2', '2'),
           Array('3', '3'),
           Array('4', '4'),
           Array('5', '5'),
           Array('6', '6'),
           Array('7', '7')
         ),
    	)
    ),
    'pdf_info' => Array (
    	'exclude' => 0,
    	'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_entry.pdf_info',
    	'config' => Array (
				'type' => 'input',	
				'size' => '70',
			)
    ),		
		
	),
	'types' => Array (
		'0' => Array('showitem' => 'hidden;;1;;1-1-1, name, street, zip, city, tel, fax, mobil, email, www, profile, image, category, map, description, features, price, priceinfo, stars, capacity, ads, detail, belongsto, do_not_filter,mindestaufenthalt,pdf_info')
	),
	'palettes' => Array (
		'1' => Array('showitem' => 'starttime, endtime')
	)
);          



$TCA['tx_pobdir_category'] = Array (
	'ctrl' => $TCA['tx_pobdir_category']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'hidden,name'
	),
	'feInterface' => $TCA['tx_pobdir_category']['feInterface'],
	'columns' => Array (
		'hidden' => Array (		
			'exclude' => 1,	
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.hidden',
			'config' => Array (
				'type' => 'check',
				'default' => '0'
			)
		),
		'name' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_category.name',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
	),
	'types' => Array (
		'0' => Array('showitem' => 'hidden;;1;;1-1-1, name') 
	),
	'palettes' => Array (
		'1' => Array('showitem' => '')
	)
);


$TCA['tx_pobdir_ad'] = Array (
	'ctrl' => $TCA['tx_pobdir_ad']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'hidden, name, ad'
	),
	'feInterface' => $TCA['tx_pobdir_ad']['feInterface'],
	'columns' => Array (
    'hidden' => Array (		
			'exclude' => 1,	
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.hidden',
			'config' => Array (
				'type' => 'check',
				'default' => '0'
			)
		),		
		'name' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_ad.name',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'ad' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_ad.ad',		
			'config' => Array (
    		'type' => 'text',
    		'cols' => '120',
    		'rows' => '7',
    		'eval' => 'required',
    	)
		),
	),
	'types' => Array (
		'0' => Array('showitem' => 'hidden;;1;;1-1-1, name, ad')
	),
	'palettes' => Array (
		'1' => Array('showitem' => '')
	)
);


$TCA['tx_pobdir_feature'] = Array (
	'ctrl' => $TCA['tx_pobdir_feature']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'hidden, name, pikto, title'
	),
	'feInterface' => $TCA['tx_pobdir_feature']['feInterface'],
	'columns' => Array (		
		'name' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_feature.name',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'pikto' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_feature.pikto',		
			'config' => Array (
    		'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
    	)
		),
		'title' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_feature.title',		
			'config' => Array (
    		'type' => 'input',	
				'size' => '30',	
    	)
		),
	),
	'types' => Array (
		'0' => Array('showitem' => 'hidden;;1;;1-1-1, name, pikto, title')
	),
	'palettes' => Array (
		'1' => Array('showitem' => '')
	)
);


$TCA['tx_pobdir_sperrzeiten'] = Array (
	'ctrl' => $TCA['tx_pobdir_sperrzeiten']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'entry_uid,deleted,gesperrt_von,gesperrt_bis'
	),
	'feInterface' => $TCA['tx_pobdir_sperrzeiten']['feInterface'],
	'columns' => Array (
		'deleted' => Array (		
			'exclude' => 1,	
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_sperrzeiten.deleted',
			'config' => Array (
				'type' => 'check',
				'default' => '0'
			)
		),
    'entry_uid' => Array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_sperrzeiten.entry_uid',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
    'gesperrt_von' => Array (		
			'exclude' => 0,	
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_sperrzeiten.gesperrt_von',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date,required',
				'default' => '0',
				'checkbox' => '0'
			)
		),
		'gesperrt_bis' => Array (		
			'exclude' => 0,	
			'label' => 'LLL:EXT:pobdir/locallang_db.php:tx_pobdir_sperrzeiten.gesperrt_bis',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date,required',
				'default' => '0',
				'checkbox' => '0'
			)
		),
		
	),
	'types' => Array (
		'0' => Array('showitem' => 'hidden;;1;;1-1-1,entry_uid,deleted,gesperrt_von,gesperrt_bis')
	),
	'palettes' => Array (
		'1' => Array('showitem' => '')
	)
);

