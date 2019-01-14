<?php

function getData()
{
  $structure = array(
    'site' => array('titel', 'icoon'),
    'kop' => array('logo', 'beschrijving', 'titel', 'tekst'),
    'blok_intro' => array('unieke_bloknaam', 'afbeelding', 'titel', 'tekst', 'knoptekst', 'knoplink'),
    'blok_stappen' => array('unieke_bloknaam', 'titel', 'afbeelding', 'beschrijving', 'tekst'),
    'blok_bullets' => array('unieke_bloknaam', 'titel', 'afbeelding', 'koptekst', 'tekst'),
    'blok_tekst' => array('unieke_bloknaam', 'titel', 'tekst'),
    'blok_video' => array('unieke_bloknaam', 'titel', 'video', 'videostill', 'ondertitel', 'audiodescriptie', 'downloadalternatief', 'tekstalternatief'),
    'blok_actie' => array('unieke_bloknaam', 'titel', 'afbeelding', 'koptekst', 'tekst', 'knoptekst', 'knoplink'),
    'blok_vragen' => array('unieke_bloknaam', 'titel', 'knoptekst', 'vraag', 'antwoord'),
		'blok_deelnemers' => array('unieke_bloknaam', 'titel', 'kolommen', 'logo', 'beschrijving'),
		'blok_tabel' => array('unieke_bloknaam', 'kolom_titel', 'rij_titel', 'rij_titel_link', 'rij_inhoud'),
		'blok_quiz' => array('unieke_bloknaam', 'titel', 'stelling', 'antwoord', 'waar', 'niet_waar'),
		'pagina' => array('unieke_paginanaam', 'titel', 'bestand'),
		'blok_vragen_categorie' => array('unieke_bloknaam', 'afbeelding', 'categorie', 'vraag', 'link', 'antwoord'),
		'blok_afbeelding' => array('unieke_bloknaam', 'titel', 'tekst', 'afbeelding', 'beschrijving'),
		'blok_code' => array('unieke_bloknaam', 'tekst', 'code')
  );
  $data = array();
	$pages = array();
	$submenu = array();
	$files = array('inhoud.ini');

	// get pages
	foreach(file($files[0], FILE_IGNORE_NEW_LINES) as $line)
	{
		if($line == '[pagina]')
		{
			$p = array(
				'uri' => '',
				'title' => '',
				'file' => ''
			);
		}
		elseif(strpos($line, '=') !== false)
		{
			$parts = explode('=', $line);
			$key = trim($parts[0]);
			$value = trim($parts[1]);

			if($key == 'url')
			{
				$p['uri'] = $value;
			}
			elseif($key == 'titel')
			{
				$p['title'] = $value;
			}
			elseif($key == 'bestand')
			{
				$p['file'] = $value;
			}
			elseif($key == 'menu')
			{
				$p['menu'] = ($value == 'ja');
				$pages[$p['uri']] = $p;
				unset($p);
			}
		}
	}

	// get current page
	if($pages)
	{
		if(isset($_GET['uri']))
		{
			if(isset($pages[$_GET['uri']]))
			{
				$page = $_GET['uri'];
			}
			else
			{
				header("HTTP/1.0 404 Not Found");
				$page = '404_pagina_niet_gevonden';
			}
		}

		if(!isset($page))
		{
			$page = reset(array_keys($pages));
		}

		$files[] = $pages[$page]['file'];
	}

	// get submenu
	$readSubMenu = false;
	foreach($files as $file)
	{
		foreach(file($file, FILE_IGNORE_NEW_LINES) as $line)
		{
			if($line == '[submenu]')
			{
				$readSubMenu = true;
				continue;
			}
			elseif($readSubMenu && strpos($line, '[') !== false)
			{
				$readSubMenu = false;
			}

			if($readSubMenu && strpos($line, '=') !== false)
			{
				$parts = explode('=', $line);
				$submenu[] = array(
					'title' => trim($parts[0]),
					'link' => trim($parts[1])
				);
			}
		}
	}

	// get data
	$module = null;
	$key = null;
	$content = null;

	foreach($files as $file)
	{
		foreach(file($file) as $line)
	  {
	    // negeer commentaar en paginas
	    if(substr(trim($line), 0, 1) != ';')
	    {
	      // nieuwe module gevonden (tussen rechte haken)
	      if(preg_match('/\[('.implode('|', array_keys($structure)).')\]/', $line, $result))
	      {
	        if($content && $module)
	        {
	          $module['content'][] = $content;
	          $content = null;
	          $key = null;
	        }

	        if($module)
	        {
	          $data[] = $module;
	        }

	        $module = array(
	          'name'=> $result[1],
	          'content' => array()
	        );
	      }
	      // nieuwe key gevonden
	      elseif(
	        $module
	        && preg_match('/\A\s*('.implode('|', $structure[$module['name']]).')\s*=(.*)/', $line, $result)
	      )
	      {
	        if($content && $module)
	        {
	          $module['content'][] = $content;
	        }

	        $key = $result[1];
	        $value = $result[2];

	        $content = array(
	          'name' => $key,
	          'value' => ltrim($value)
	        );
	      }
	      // plak waarde aan bestaande module/key
	      elseif($module && $key)
	      {
	        $content['value'] .= "\r\n".rtrim($line);
	      }
	    }
	  }
	  // laatste module + content ook toevoegen
	  if($content && $module)
	  {
	    $module['content'][] = $content;
	  }
	  if($module)
	  {
	    $data[] = $module;
	  }

		// trim data
		for($i = 0; $i < count($data); $i += 1)
		{
			for($j = 0; $j < count($data[$i]['content']); $j += 1)
			{
				$data[$i]['content'][$j]['value'] = trim($data[$i]['content'][$j]['value']);
			}
		}
	}

  return array(
		'data' => $data,
		'pages' => $pages,
		'page' => $page,
		'submenu' => $submenu
	);
}

$data = getData();

?>
