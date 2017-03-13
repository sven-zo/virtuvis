<?php

/**
 * Weather Class
 * This class is written to speed up the fetching data from the wikipedia API
 */
class Wiki extends Api
{
    private $language;
    private $description;
    private $image;


    public function __construct($language)
    {
        $this->language = $language;
    }

    /**
     * @param $species
     * @return string
     */
    public function getDescription($species)
    {
        // https://en.wikipedia.org/w/api.php?action=parse&page=cheese&prop=sections&format=json

        $language = $this->language;
        $endpoint = 'https://'.$language.'.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles='.$species;

        $descriptionData = $this->curlRequest($endpoint);

        $description = '';

        foreach($descriptionData->query->pages as $key => $wiki){
            $description = $wiki->extract;
        }

        $this->description = $description;

        return $this->description;
    }

    /**
     * It's Important to search in english, Dutch wikipedia pages do not provide the right images
     * @param $species
     * @return string
     */
    public function getImage($species)
    {
        $endpointFileNames = 'https://en.wikipedia.org/w/api.php?format=json&action=query&prop=images&titles='.$species;

        $filenameData =  $this->curlRequest($endpointFileNames);
        $filename = '';

        foreach($filenameData->query->pages as $key => $wiki){
            $filename = $wiki->images[0]->title;
        }

        $filename = str_replace(' ', '%20', $filename);
        $endpointImageUrl = 'https://en.wikipedia.org/w/api.php?action=query&titles='.$filename.'&prop=imageinfo&iiprop=url&format=json';


        $imageData = $this->curlRequest($endpointImageUrl);
        $image = '';
        foreach($imageData->query->pages as $key => $wiki){
            $image = $wiki->imageinfo[0]->url;
        }

        $this->image = $image;

        return $this->image;
    }
}