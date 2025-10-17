<?php

namespace Purpozed2;

class Router {
    private $controllerDirectory;
    private $templateDirectory;
    private $controller;

    private function getControllersForTemplates($controllerDirectory) {
        $controllers = array();
        $files = array_slice(scandir($controllerDirectory), 2);
        foreach($files as $file) {
            class_exists('\Purpozed2\Controllers\\' . ucfirst(pathinfo($file, PATHINFO_FILENAME)));
            $className = ('\Purpozed2\Controllers\\' . ucfirst(pathinfo($file, PATHINFO_FILENAME)));
            $controllers[] = new $className;
        }
        return $controllers;
    }

    public function __construct() {
        $this->controllerDirectory = plugin_dir_path(__FILE__) . 'controllers/';
        $this->templateDirectory = plugin_dir_path(__FILE__) . 'templates/';
        $this->registerHooks();
    }

    public function registerHooks() {
        add_filter('theme_page_templates', array($this, 'addTemplatesToTheme'));
        add_filter('page_template', array($this, 'redirectTemplate'));
    }

    public function addTemplatesToTheme($templates) {
        global $allowed_files;
        $controllers = $this->getControllersForTemplates($this->controllerDirectory);
        foreach($controllers as $controller) {
            $allowed_files[$controller->getTemplate()] = $controller->getTemplate();
            $templates['templates/' . $controller->getTemplate() . '.php'] = $controller->getDescription();
        }
        return $templates;
    }

    public function redirectTemplate($templateToLoad) {
        $baseName = baseName($templateToLoad);
        if($baseName == 'page.php') {
            $baseName = baseName(get_page_template_slug(get_queried_object_id()));
        }
        if($baseName && file_exists($this->templateDirectory . $baseName)) {
            $controllerClass = '\Purpozed2\Controllers\\' . pathinfo($baseName, PATHINFO_FILENAME);
            $this->controller = new $controllerClass;
            $this->controller->setViewVariables();
            add_filter( 'template_include', array($this, 'includeTemplate'));
            return $this->templateDirectory . $baseName;
        }
        return $templateToLoad;
    }

    public function includeTemplate($template) {
        extract($this->controller->getViewVariables());
        include($template);
        return false;
    }
}