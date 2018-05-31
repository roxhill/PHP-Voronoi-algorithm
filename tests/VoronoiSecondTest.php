<?php

use PHPUnit\Framework\TestCase;
use PhpVoronoiAlgorithm\Nurbs\Point;
use PhpVoronoiAlgorithm\Nurbs\Voronoi;

class VoronoiSecondTest extends TestCase
{
    /**
     * @test
     */
    public function evaluateSpecificPointsSecond()
    {
        // Create the border box object
        $bbox = new \stdClass();
        $bbox->xl = -100;
        $bbox->xr = 100;
        $bbox->yt = 200;
        $bbox->yb = 300;

        $point = new Point(-5.9301, 54.5973);
        $sites[] = $point;

        $point = new Point(-7.3100, 54.5977);
        $sites[] = $point;

        $point = new Point(-6.6528, 54.3503);
        $sites[] = $point;

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
}