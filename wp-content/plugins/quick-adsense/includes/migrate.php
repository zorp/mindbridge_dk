<?php 
global $QData;
$QData['AdsWid'] = 10;
$QData['Ads'] = 10;
$QData['Name'] = 'Quick Adsense';
$QData['Version'] = '1.9.4';
$QData['URI'] = 'http://quickadsense.com/';
$QData['AdsWidName'] = 'AdsWidget%d (Quick Adsense)';
$QData['Default'] = array(
	'AdsDisp' => '3',
	'BegnAds' => true,
	'BegnRnd' => '1',
	'EndiAds' => true,
	'EndiRnd' => '0',
	'MiddAds' => false,
	'MiddRnd' => '0',
	'MoreAds' => false,
	'MoreRnd' => '0',
	'LapaAds' => false,
	'LapaRnd' => '0',
	'Par1Ads' => false,
	'Par1Rnd' => '0',
	'Par1Nup' => '0',
	'Par1Con' => false,
	'Par2Ads' => false,
	'Par2Rnd' => '0',
	'Par2Nup' => '0',
	'Par2Con' => false,
	'Par3Ads' => false,
	'Par3Rnd' => '0',
	'Par3Nup' => '0',
	'Par3Con' => false,
	'Img1Ads' => false,
	'Img1Rnd' => '0',
	'Img1Nup' => '0',
	'Img1Con' => true,
	'AppPost' => true,
	'AppPage' => true,
	'AppHome' => false,
	'AppCate' => false,
	'AppArch' => false,
	'AppTags' => false,
	'AppMaxA' => false,
	'AppSide' => false,
	'AppLogg' => false,
	'QckTags' => true,
	'QckRnds' => false,
	'QckOffs' => false,
	'QckOfPs' => false
);

$QData['DefaultAdsOpt'] = array(
	'AdsMargin' => '10',
	'AdsAlign' => '2'
);
$QData['DefaultAdsName'] = array();

for($i = 1; $i <= $QData['Ads']; $i++) { 
	array_push($QData['DefaultAdsName'], 'AdsCode'.$i);
	array_push($QData['DefaultAdsName'], 'AdsAlign'.$i);
	array_push($QData['DefaultAdsName'], 'AdsMargin'.$i);
};

for($i = 1; $i <= $QData['AdsWid']; $i++) { 
	array_push($QData['DefaultAdsName'], 'WidCode'.$i);	
};


function quick_adsense_2_get_options_with_defaults() {
	global $QData;
	//delete_option('quick_adsense_2_options');
	$options = get_option('quick_adsense_2_options');
	if(!is_array($options) || (count($options) < 1)) {
		$oldData = get_option('AdsDisp');
		if(!isset($oldData) && is_bool($oldData)) {
			$options = array (
				'AdsDisp' => $QData['Default']['AdsDisp'],
				'BegnAds' => $QData['Default']['BegnAds'],
				'BegnRnd' => $QData['Default']['BegnRnd'],
				'MiddAds' => $QData['Default']['MiddAds'],
				'MiddRnd' => $QData['Default']['MiddRnd'],
				'EndiAds' => $QData['Default']['EndiAds'],
				'EndiRnd' => $QData['Default']['EndiRnd'],
				'MoreAds' => $QData['Default']['MoreAds'],
				'MoreRnd' => $QData['Default']['MoreRnd'],
				'LapaAds' => $QData['Default']['LapaAds'],
				'LapaRnd' => $QData['Default']['LapaRnd'],
				'Par1Ads' => $QData['Default']['Par1Ads'],
				'Par1Rnd' => $QData['Default']['Par1Rnd'],
				'Par1Nup' => $QData['Default']['Par1Nup'],
				'Par1Con' => $QData['Default']['Par1Con'],
				'Par2Ads' => $QData['Default']['Par2Ads'],
				'Par2Rnd' => $QData['Default']['Par2Rnd'],
				'Par2Nup' => $QData['Default']['Par2Nup'],
				'Par2Con' => $QData['Default']['Par2Con'],
				'Par3Ads' => $QData['Default']['Par3Ads'],
				'Par3Rnd' => $QData['Default']['Par3Rnd'],
				'Par3Nup' => $QData['Default']['Par3Nup'],
				'Par3Con' => $QData['Default']['Par3Con'],
				'Img1Ads' => $QData['Default']['Img1Ads'],
				'Img1Rnd' => $QData['Default']['Img1Rnd'],
				'Img1Nup' => $QData['Default']['Img1Nup'],
				'Img1Con' => $QData['Default']['Img1Con'],
				'AppPost' => $QData['Default']['AppPost'],
				'AppPage' => $QData['Default']['AppPage'],
				'AppHome' => $QData['Default']['AppHome'],
				'AppCate' => $QData['Default']['AppCate'],
				'AppArch' => $QData['Default']['AppArch'],
				'AppTags' => $QData['Default']['AppTags'],
				'AppMaxA' => $QData['Default']['AppMaxA'],
				'AppSide' => $QData['Default']['AppSide'],
				'AppLogg' => $QData['Default']['AppLogg'],
				'QckTags' => $QData['Default']['QckTags'],
				'QckRnds' => $QData['Default']['QckRnds'],
				'QckOffs' => $QData['Default']['QckOffs'],
				'QckOfPs' => $QData['Default']['QckOfPs'],
				'AdsCode1' => '',
				'AdsAlign1' => 2,
				'AdsMargin1' => 10,
				'AdsCode2' => '',
				'AdsAlign2' => 2,
				'AdsMargin2' => 10,
				'AdsCode3' => '',
				'AdsAlign3' => 2,
				'AdsMargin3' => 10,
				'AdsCode4' => '',
				'AdsAlign4' => 2,
				'AdsMargin4' => 10,
				'AdsCode5' => '',
				'AdsAlign5' => 2,
				'AdsMargin5' => 10,
				'AdsCode6' => '',
				'AdsAlign6' => 2,
				'AdsMargin6' => 10,
				'AdsCode7' => '',
				'AdsAlign7' => 2,
				'AdsMargin7' => 10,
				'AdsCode8' => '',
				'AdsAlign8' => 2,
				'AdsMargin8' => 10,
				'AdsCode9' => '',
				'AdsAlign9' => 2,
				'AdsMargin9' => 10,
				'AdsCode10' => '',
				'AdsAlign10' => 2,
				'AdsMargin10' => 10,
				'WidCode1' => '',
				'WidCode2' => '',
				'WidCode3' => '',
				'WidCode4' => '',
				'WidCode5' => '',
				'WidCode6' => '',
				'WidCode7' => '',
				'WidCode8' => '',
				'WidCode9' => '',
				'WidCode10' => ''
			);
		} else {
			$options = array (
				'AdsDisp' => get_option('AdsDisp'),
				'BegnAds' => get_option('BegnAds'),
				'BegnRnd' => get_option('BegnRnd'),
				'MiddAds' => get_option('MiddAds'),
				'MiddRnd' => get_option('MiddRnd'),
				'EndiAds' => get_option('EndiAds'),
				'EndiRnd' => get_option('EndiRnd'),
				'MoreAds' => get_option('MoreAds'),
				'MoreRnd' => get_option('MoreRnd'),
				'LapaAds' => get_option('LapaAds'),
				'LapaRnd' => get_option('LapaRnd'),
				'Par1Ads' => get_option('Par1Ads'),
				'Par1Rnd' => get_option('Par1Rnd'),
				'Par1Nup' => get_option('Par1Nup'),
				'Par1Con' => get_option('Par1Con'),
				'Par2Ads' => get_option('Par2Ads'),
				'Par2Rnd' => get_option('Par2Rnd'),
				'Par2Nup' => get_option('Par2Nup'),
				'Par2Con' => get_option('Par2Con'),
				'Par3Ads' => get_option('Par3Ads'),
				'Par3Rnd' => get_option('Par3Rnd'),
				'Par3Nup' => get_option('Par3Nup'),
				'Par3Con' => get_option('Par3Con'),
				'Img1Ads' => get_option('Img1Ads'),
				'Img1Rnd' => get_option('Img1Rnd'),
				'Img1Nup' => get_option('Img1Nup'),
				'Img1Con' => get_option('Img1Con'),
				'AppPost' => get_option('AppPost'),
				'AppPage' => get_option('AppPage'),
				'AppHome' => get_option('AppHome'),
				'AppCate' => get_option('AppCate'),
				'AppArch' => get_option('AppArch'),
				'AppTags' => get_option('AppTags'),
				'AppMaxA' => get_option('AppMaxA'),
				'AppSide' => get_option('AppSide'),
				'AppLogg' => get_option('AppLogg'),
				'QckTags' => get_option('QckTags'),
				'QckRnds' => get_option('QckRnds'),
				'QckOffs' => get_option('QckOffs'),
				'QckOfPs' => get_option('QckOfPs'),
				'AdsCode1' => get_option('AdsCode1'),
				'AdsAlign1' => get_option('AdsAlign1'),
				'AdsMargin1' => get_option('AdsMargin1'),
				'AdsCode2' => get_option('AdsCode2'),
				'AdsAlign2' => get_option('AdsAlign2'),
				'AdsMargin2' => get_option('AdsMargin2'),
				'AdsCode3' => get_option('AdsCode3'),
				'AdsAlign3' => get_option('AdsAlign3'),
				'AdsMargin3' => get_option('AdsMargin3'),
				'AdsCode4' => get_option('AdsCode4'),
				'AdsAlign4' => get_option('AdsAlign4'),
				'AdsMargin4' => get_option('AdsMargin4'),
				'AdsCode5' => get_option('AdsCode5'),
				'AdsAlign5' => get_option('AdsAlign5'),
				'AdsMargin5' => get_option('AdsMargin5'),
				'AdsCode6' => get_option('AdsCode6'),
				'AdsAlign6' => get_option('AdsAlign6'),
				'AdsMargin6' => get_option('AdsMargin6'),
				'AdsCode7' => get_option('AdsCode7'),
				'AdsAlign7' => get_option('AdsAlign7'),
				'AdsMargin7' => get_option('AdsMargin7'),
				'AdsCode8' => get_option('AdsCode8'),
				'AdsAlign8' => get_option('AdsAlign8'),
				'AdsMargin8' => get_option('AdsMargin8'),
				'AdsCode9' => get_option('AdsCode9'),
				'AdsAlign9' => get_option('AdsAlign9'),
				'AdsMargin9' => get_option('AdsMargin9'),
				'AdsCode10' => get_option('AdsCode10'),
				'AdsAlign10' => get_option('AdsAlign10'),
				'AdsMargin10' => get_option('AdsMargin10'),
				'WidCode1' => get_option('WidCode1'),
				'WidCode2' => get_option('WidCode2'),
				'WidCode3' => get_option('WidCode3'),
				'WidCode4' => get_option('WidCode4'),
				'WidCode5' => get_option('WidCode5'),
				'WidCode6' => get_option('WidCode6'),
				'WidCode7' => get_option('WidCode7'),
				'WidCode8' => get_option('WidCode8'),
				'WidCode9' => get_option('WidCode9'),
				'WidCode10' => get_option('WidCode10')
			);
		}
		delete_option('AdsDisp');
		update_option('quick_adsense_2_options', $options);
	}
	return $options;
}
?>