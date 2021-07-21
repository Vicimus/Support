<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Http\Response;

/**
 * Interface PageController
 */
interface PageController
{
    /**
     * Show the Page based on the URL. This method is called after all other
     * routes are checked. So all other packages routes take precedence over
     * eevee pages (which is what should happen) and finally if no route is
     * matched the URL, it tries to find a Page for it.
     *
     * @param string[] $args Arguments containing a page to show
     *
     * @return Response
     */
    public function show(array $args = []): Response;
}
