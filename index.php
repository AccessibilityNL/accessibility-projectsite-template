<?php

error_reporting(E_ALL);

define('TEMPLATE_DIR', __DIR__.'/html/');
define('FILE_DIR', __DIR__.'/bestanden/');

include('app/data.php');
include('app/template.php');

// head
$template = new template();
foreach($data['data'] as $module)
{
  if($module['name'] == 'site'
  || $module['name'] == 'kop')
  {
    $content = array();
    foreach($module['content'] as $row)
    {
      $content[$row['name']] = $row['value'];
    }

    $template->set($module['name'], $content);
  }
}
$template->set('pages', $data['pages']);
$template->set('page', $data['page']);
$template->set('submenu', $data['submenu']);
$template->show('_head');

// blokken
foreach($data['data'] as $module)
{
  if(strpos($module['name'], 'blok_') === 0)
  {
    $template = new template();

    $groups = array();

    foreach($module['content'] as $i => $row)
    {
      if(in_array($module['name'], array('blok_stappen', 'blok_bullets'))
      && !in_array($row['name'], array('unieke_bloknaam', 'titel')))
      {
        if($row['name'] == 'afbeelding')
        {
          $group = array(
            $row['name'] => $row['value']
          );
        }
        elseif($row['name'] == 'tekst')
        {
          $group[$row['name']] = $row['value'];

          $groups[] = $group;
        }
        else
        {
          $group[$row['name']] = $row['value'];
        }
      }
			elseif(in_array($module['name'], array('blok_vragen_categorie'))
			&& !in_array($row['name'], array('unieke_bloknaam')))
			{
				if($row['name'] == 'afbeelding')
				{
					$group = array();
				}

				$group[$row['name']] = $row['value'];

				if($row['name'] == 'categorie')
				{
					if(!isset($groups['cat']))
					{
						$groups['cat'] = array();
					}

          $categoryValues = explode(',', strtolower($row['value']));

          foreach ($categoryValues as $i => $category) {
            $trimmedCat = trim($category);
            if(!in_array($trimmedCat, $groups['cat']))
  					{
  						$groups['cat'][] = $trimmedCat;
  					}
          }
				}

				if($row['name'] == 'antwoord')
				{
					$groups[] = $group;
				}
			}
			elseif(in_array($module['name'], array('blok_quiz'))
			&& !in_array($row['name'], array('unieke_bloknaam', 'titel')))
			{
				if($row['name'] == 'stelling')
				{
					$group = array();
				}

				$group[$row['name']] = $row['value'];

				if($row['name'] == 'niet_waar')
				{
					$groups[] = $group;
				}
			}
			elseif(in_array($module['name'], array('blok_vragen'))
      && !in_array($row['name'], array('unieke_bloknaam', 'titel', 'knoptekst')))
			{
				if($row['name'] == 'vraag')
        {
          $group = array(
            $row['name'] => $row['value']
          );
        }
				else
				{
					$group[$row['name']] = $row['value'];

					$groups[] = $group;
				}
			}
			elseif($module['name'] == 'blok_deelnemers'
			&& !in_array($row['name'], array('unieke_bloknaam', 'titel', 'kolommen')))
			{
				if($row['name'] == 'logo')
				{
					$group = array(
						$row['name'] => $row['value']
					);
				}
				else
        {
          $group[$row['name']] = $row['value'];
					$groups[] = $group;
        }
			}
			elseif($module['name'] == 'blok_tabel'
			&& !in_array($row['name'], array('unieke_bloknaam')))
			{
				if($row['name'] == 'kolom_titel')
				{
					if(!$groups)
					{
						$groups = array(
							'kolommen' => array(),
							'rijen' => array()
						);
					}

					$groups['kolommen'][] = $row['value'];
				}
				elseif($row['name'] == 'rij_titel')
				{
					if(isset($r) && $r)
					{
						$groups['rijen'][] = $r;
					}

					$r = array(
						'koptekst' => $row['value'],
						'inhoud' => array()
					);
				}
				elseif($row['name'] == 'rij_titel_link')
				{
					$r['link'] = $row['value'];
				}
				else
				{
					$r['inhoud'][] = $row['value'];

					if($i == count($module['content']) - 1)
					{
						$groups['rijen'][] = $r;
					}
				}
			}
      else
      {
        $template->set($row['name'], $row['value']);
      }
    }

    if($groups)
    {
      $template->set('groepen', $groups);
    }

    $template->show($module['name']);
  }
}

// footer
$template = new template();
$template->show('_foot');

?>
