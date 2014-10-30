<?php namespace Brill;

class Router extends \Slim\Router
{
    /**
     * Get URL for named route
     * @param  string            $name   The name of the route
     * @param  array             $params Associative array of URL parameter names and replacement values. Unmatched parameters will be used to build the query string.
     * @return string                    The URL for the given route populated with provided replacement values
     * @throws \RuntimeException         If named route not found
     * @api
     */
    public function urlFor($name, $params = array())
    {
        if (!$this->hasNamedRoute($name)) {
            throw new \RuntimeException('Named route not found for name: ' . $name);
        }

        $url = $this->getNamedRoute($name)->getPattern();

        foreach ($params as $key => $value) {
            $search = '#:' . preg_quote($key, '#') . '\+?(?!\w)#';
            if (preg_match($search, $url)) {
                $url = preg_replace($search, $value, $url);
                unset($params[$key]);
            }
        }

        //Remove remnants of unpopulated, trailing optional pattern segments, escaped special characters
        $url = preg_replace('#\(/?:.+\)|\(|\)|\\\\#', '', $url);

        // Leftovers are added as url query string
        if ($params) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }
}
