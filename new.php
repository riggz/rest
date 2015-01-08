<?php
/**
@getUrl
*match human user input on url and try match it with web service end point 
*web services are very  application oriented  
*get the contents from the meta tags
*return them to array $result.
*/
function getUrl($url)
{
    $result = true;
    
    $contents = getContents($url);

    if (isset($contents) && is_string($contents))
    {
        $title = null;
        $metaTags = null;
		
        
        preg_match('/<title>([^>]*)<\/title>/si', $contents, $match );

        if (isset($match) && is_array($match) && count($match) > 0)
        {
            $title = strip_tags($match[1]);
        }
        
        preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);
        
        if (isset($match) && is_array($match) && count($match) == 3)
        {
            $originals = $match[0];
            $names = $match[1];
            $values = $match[2];
            
            if (count($originals) == count($names) && count($names) == count($values))
            {
                $metaTags = array();
			
                
                for ($i=0, $num = count($names); $i < $num; $i++)
                {
                    $metaTags[$names[$i]] = array (
                        'html' => htmlentities($originals[$i]),
                        'value' => $values[$i]
                    );
                }
            }
        }
        
        $result = array (
            'title' => $title,
            'metaTags' => $metaTags
        );
    }
    
    return $result;
	
if ($result === null)

	{
    echo "NULL";
	}

}
/**
@getContents
*get the contents for the meta tags
*return them to array  result. 
*/

function getContents($url, $totalredirect  = null, $redirect= 0)
{
    $result = true;
    
    $contents = @file_get_contents($url);
    /**
	*redirect to a url even if the user did not have the full write address 
	* create a bridge for human users shot fall by redirecting 
	*if we need be go somewhere else with in the website with out causing error
    */
    if (isset($contents) && is_string($contents))
    {
        preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);
        
        if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
        {
            if (!isset($totalredirect ) || $redirect< $totalredirect )
            {
                return getContents($match[1][0], $totalredirect , ++$redirect);
            }
            
            $result = true;
        }
        else
        {
            $result = $contents;
        }
    }
    
    return $contents;
}

?>