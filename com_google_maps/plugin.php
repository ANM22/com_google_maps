<?php

/**
 * Google Maps plugin for ANM22 WebBase CMS.
 * 
 * @author Andrea Menghi <andrea.menghi@anm22.it>
 */
class com_google_maps_embeded extends com_anm22_wb_editor_page_element {

    var $elementClass = "com_google_maps_embeded";
    var $elementPlugin = "com_google_maps";
    var $elementClassName = "Google Maps";
    var $elementClassIcon = "images/plugin_icons/com_google_maps.png";
    var $title;
    private $headingTag = 'h1';
    var $mapLink;
    var $description;
    var $mapMaxWidth;
    var $mapHeight;
    private $lockScroll = 0;

    /**
     * @deprecated since editor 3.0
     * 
     * Method to init the element.
     * 
     * @param SimpleXMLElement $xml Element data
     * @return void
     */
    function importXMLdoJob($xml)
    {
        $this->title = htmlspecialchars_decode($xml->title);
        $this->mapLink = htmlspecialchars_decode($xml->mapLink);
        $this->description = htmlspecialchars_decode($xml->description);
        $this->mapMaxWidth = $xml->mapMaxWidth;
        $this->mapHeight = $xml->mapHeight;
        $this->setLockScroll(intval($xml->lockScroll));
        if (isset($xml->headingTag)) {
            $this->setHeadingTag(htmlspecialchars_decode($xml->headingTag));
        }
    }

    /**
     * Method to init the element.
     * 
     * @param mixed[] $data Element data
     * @return void
     */
    public function initData($data)
    {
        $this->title = $data['title'];
        if ($data['mapLink']) {
            $this->mapLink = htmlspecialchars_decode($data['mapLink']);
        }
        if ($data['description']) {
            $this->description = htmlspecialchars_decode($data['description']);
        }
        $this->mapMaxWidth = $data['mapMaxWidth'];
        $this->mapHeight = $data['mapHeight'];
        $this->setLockScroll(intval($data['lockScroll']));
        if (isset($data['headingTag']) && $data['headingTag']) {
            $this->setHeadingTag(htmlspecialchars_decode($data['headingTag']));
        }
    }

    /**
     * Render the page element
     * 
     * @return void
     */
    function show()
    {
        if ($this->getLockScroll()) {
            echo '<link rel="stylesheet" href="' . $this->page->getHomeFolderRelativeHTMLURL() . 'ANM22WebBase/website/plugins/' . $this->elementPlugin . '/css/scrollLockStyles.min.css">';
        }
        echo '<div class="' . $this->elementPlugin . '_' . $this->elementClass . '"';
            if ($this->getLockScroll()) {
                echo ' onclick="this.className=\'' . $this->elementPlugin . '_' . $this->elementClass . ' scrollActive\'"';
            }
            echo '>';
            if ($this->title && $this->title != "") {
                echo '<' . $this->getHeadingTag();
                if (isset($this->page->pageOptions["h1-color"]) && $this->page->pageOptions["h1-color"]) {
                    echo ' style="color:' . $this->page->pageOptions["h1-color"] . ';"';
                }
                echo '>' . $this->title . '</' . $this->getHeadingTag() . '>';
            }
            if ($this->mapLink != "") {
                if ($this->mapMaxWidth == "" || (!$this->mapMaxWidth)) {
                    $maxWidth = "100%";
                } else {
                    $maxWidth = $this->mapMaxWidth;
                }
                if ($this->mapHeight == "" || (!$this->mapHeight)) {
                    $height = "450px";
                } else {
                    $height = $this->mapHeight;
                }
                echo '<iframe src="' . $this->mapLink . '" frameborder="0" ';
                if ($this->getLockScroll()) {
                    echo 'scrolling="no" ';
                }
                echo 'style="border:0;width:' . $maxWidth . ';height:' . $height . ';"></iframe>';
            }
            if ($this->description != "") {
                echo '<p style="color:' . $this->page->pageOptions["p-color"] . ';">' . nl2br($this->description) . '</p>';
            }
        echo '</div>';
    }
    
    public function getLockScroll()
    {
        return $this->lockScroll;
    }
    public function setLockScroll($lockScroll)
    {
        $this->lockScroll = $lockScroll;
        return $this;
    }
    
    public function getHeadingTag()
    {
        return $this->headingTag;
    }
    public function setHeadingTag($headingTag)
    {
        $this->headingTag = $headingTag;
        return $this;
    }

} 