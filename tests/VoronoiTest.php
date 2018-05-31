<?php

use PHPUnit\Framework\TestCase;
use PhpVoronoiAlgorithm\Nurbs\Point;
use PhpVoronoiAlgorithm\Nurbs\Voronoi;

class VoronoiTest extends TestCase
{

    /**
     * @test
     */
    public function evaluateSpecificPoints()
    {
        // Create the border box object
        $bbox = new \stdClass();
        $bbox->xl = -10;
        $bbox->xr = 0;
        $bbox->yt = 40;
        $bbox->yb = 60;

        $xo = -10;
        $dx = $width = 0;
        $yo = 40;
        $dy = $height = 60;
        $n = 2;
        $sites = array();

// Create the image
//        $im = imagecreatetruecolor($width, $height);
//        $white = imagecolorallocate($im, 255, 255, 255);
//        $red = imagecolorallocate($im, 255, 0, 0);
//        $green = imagecolorallocate($im, 0, 100, 0);
//        $black = imagecolorallocate($im, 0, 0, 0);
//        imagefill($im, 0, 0, $white);

// Create random points and draw them
//for ($i=0; $i < $n; $i++) {

// Paris
// Belfast

// need to be storing the post-code along with these data
// will end up with array of polygons each associated with a single postcode lat-long

//	$point = new Nurbs_Point(2.3522, 48.8566);
        $point = new Point(-5.9301, 54.5973);
        $sites[] = $point;

//        imagerectangle($im, $point->x - 2, $point->y - 2, $point->x + 2, $point->y + 2, $black);

// Berlin
// Omagh

//$point = new Nurbs_Point(13.4050, 52.5200);
        $point = new Point(-7.3100, 54.5977);

        $sites[] = $point;

//        imagerectangle($im, $point->x - 2, $point->y - 2, $point->x + 2, $point->y + 2, $black);

// Barcelona
//

//$point = new Nurbs_Point(2.1734, 41.3851);
        $point = new Point(-6.6528, 54.3503);
        $sites[] = $point;

//        imagerectangle($im, $point->x - 2, $point->y - 2, $point->x + 2, $point->y + 2, $black);

//}

        $voronoi = new Voronoi();
        $diagram = $voronoi->compute($sites, $bbox);

var_dump($diagram['cells']);

// want the

        $j = 0;
        foreach ($diagram['cells'] as $cell) {
            $points = array();

            if (count($cell->_halfedges) > 0) {
                $v = $cell->_halfedges[0]->getStartPoint();
                if ($v) {
                    $points[] = $v->x;
                    $points[] = $v->y;
                } else {
                    var_dump($j.': no start point');
                }

                for ($i = 0; $i < count($cell->_halfedges); $i++) {
                    $halfedge = $cell->_halfedges[$i];
                    $edge = $halfedge->edge;

//                    if ($edge->va && $edge->vb) {
//                        imageline($im, $edge->va->x, $edge->va->y, $edge->vb->x, $edge->vb->y, $red);
//                    }

                    $v = $halfedge->getEndPoint();
                    if ($v) {
                        $points[] = $v->x;
                        $points[] = $v->y;
                    } else {
                        var_dump($j.': no end point #'.$i);
                    }
                }
            }

            // check that these are valid i.e., can be loaded into geoPHP
//	var_export($points);

            foreach($points as $key => $value) {
                if ($key === 0) {
                    print("\n");
                }
                var_export($value);
                if ($key %2 === 0) {
                    print(" ");
                } else {
                    print(",");
                }
            }

            print("\n");

            // Draw Thyssen polygon
//            $color = imagecolorallocatealpha($im, rand(0, 255), rand(0, 255), rand(0, 255), 50);
//            imagefilledpolygon($im, $points, count($points) / 2, $color);
            $j++;
        }

// Display image
//        imagepng($im, 'voronoi.png');
    }

    /**
     * @test
     */
    public function evaluateRandomPointsWithImage()
    {
// Create the border box object
        $bbox = new stdClass();
        $bbox->xl = 0;
        $bbox->xr = 400;
        $bbox->yt = 0;
        $bbox->yb = 400;

        $xo = 0;
        $dx = $width = 400;
        $yo = 0;
        $dy = $height = 400;
        $n = 10;
        $sites = array();

// Create the image
        $im = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($im, 255, 255, 255);
        $red = imagecolorallocate($im, 255, 0, 0);
        $green = imagecolorallocate($im, 0, 100, 0);
        $black = imagecolorallocate($im, 0, 0, 0);
        imagefill($im, 0, 0, $white);

// Create random points and draw them
        for ($i=0; $i < $n; $i++) {
//            $point = new Point(rand($xo, $dx), rand($yo, $dy));
            $point = new Point(($xo + lcg_value()*(abs($dx - $xo))), ($yo + lcg_value()*(abs($dy - $yo))));

            var_dump("i = {$i}");
            var_dump($point->x);
            var_dump($point->y);

            $sites[] = $point;

            imagerectangle($im, $point->x - 2, $point->y - 2, $point->x + 2, $point->y + 2, $black);
        }

        $voronoi = new Voronoi();
        $diagram = $voronoi->compute($sites, $bbox);

        $j = 0;
        foreach ($diagram['cells'] as $cell) {
            $points = array();

            if (count($cell->_halfedges) > 0) {
                $v = $cell->_halfedges[0]->getStartPoint();
                if ($v) {
                    $points[] = $v->x;
                    $points[] = $v->y;
                } else {
                    var_dump($j.': no start point');
                }

                for ($i = 0; $i < count($cell->_halfedges); $i++) {
                    $halfedge = $cell->_halfedges[$i];
                    $edge = $halfedge->edge;

                    if ($edge->va && $edge->vb) {
                        imageline($im, $edge->va->x, $edge->va->y, $edge->vb->x, $edge->vb->y, $red);
                    }

                    $v = $halfedge->getEndPoint();
                    if ($v) {
                        $points[] = $v->x;
                        $points[] = $v->y;
                    } else {
                        var_dump($j.': no end point #'.$i);
                    }
                }
            }

            // Draw Thyssen polygon
            $color = imagecolorallocatealpha($im, rand(0, 255), rand(0, 255), rand(0, 255), 50);
            imagefilledpolygon($im, $points, count($points) / 2, $color);
            $j++;
        }

// Display image
        imagepng($im, 'voronoi.png');
    }

    /**
     * @test
     */
    public function evaluateRandomPointsWithoutImage()
    {
// Create the border box object
//        $bbox = new stdClass();
//        $bbox->xl = 0;
//        $bbox->xr = 400;
//        $bbox->yt = 0;
//        $bbox->yb = 400;
//
//        $xo = 0;
//        $dx = $width = 400;
//        $yo = 0;
//        $dy = $height = 400;
//        $n = 200;
//        $sites = array();

        // Create the border box object
        $bbox = new \stdClass();
        $bbox->xl = 0;
        $bbox->xr = 400;
        $bbox->yt = 0;
        $bbox->yb = 400;

//        $xo = 1;
//        $dx = $width = 9;
//        $yo = 51;
//        $dy = $height = 59;
//        $n = 5;
//        $sites = array();

        $xo = 1;
        $dx = $width = 399;
        $yo = 1;
        $dy = $height = 399;
        $n = 200;
        $sites = array();

// Create random points and draw them
        for ($i=0; $i < $n; $i++) {
            var_dump("i = {$i}");
//                        $point = new Point(rand($xo, $dx), rand($yo, $dy));
            $point = new Point(  round(($xo + lcg_value()*(abs($dx - $xo))),1), round(($yo + lcg_value()*(abs($dy - $yo))),1)  );

            var_dump($point->x);
            var_dump($point->y);

            $sites[] = $point;
        }

        $voronoi = new Voronoi();
        $diagram = $voronoi->compute($sites, $bbox);
//
//        var_dump($diagram['cells']);
//
//        //
//        $j = 0;
//        foreach ($diagram['cells'] as $cell) {
//            $points = array();
//
//            if (count($cell->_halfedges) > 0) {
//                $v = $cell->_halfedges[0]->getStartPoint();
//                if ($v) {
//                    $points[] = $v->x;
//                    $points[] = $v->y;
//                } else {
//                    var_dump($j.': no start point');
//                }
//
//                for ($i = 0; $i < count($cell->_halfedges); $i++) {
//                    $halfedge = $cell->_halfedges[$i];
//                    $edge = $halfedge->edge;
//
//                    $v = $halfedge->getEndPoint();
//                    if ($v) {
//                        $points[] = $v->x;
//                        $points[] = $v->y;
//                    } else {
//                        var_dump($j.': no end point #'.$i);
//                    }
//                }
//            }
//
////            print(count($points));
//
//            foreach($points as $key => $value) {
////                print $key;
////                print "\n";
//
////                if ($key === 0) {
////                    print("\n");
////                }
////                var_export($value);
////                if ($key %2 === 0) {
////                    print(" ");
////                } else {
////                    print(",");
////                }
//            }
//
////            print("\n");
//
//            //
//            // Draw Thyssen polygon
//            $j++;
//        }
    }
}
