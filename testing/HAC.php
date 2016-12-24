<?php
function pop(&$a, $i)
{
	$foo = $a[$i];
	array_splice($a, $i, 1);
	return $foo;
}
class Cluster
{
public $left, $right, $distance;
function __construct($distance)
{
	$this->distance = $distance;
}
function __toString()
{
	return sprintf("(%s, %s)", $this->left, $this->right);
}
function add($clusters, $grid, $lefti, $righti)
{
	$this->left = $clusters[$lefti];
	$this->right = pop($clusters, $righti);
	# merge columns grid[row][righti] and row grid[righti] into corresponding lefti
	for ($i = 0; $i < count($grid); $i++)
	{
		for ($j = 0; $j < count($grid); $j++)
		{
			$grid[$i][$lefti] = min($grid[$i][$lefti], $grid[$i][$righti]);
		}
		pop($grid[$i], $righti);
	}
	$r = pop($grid, $righti);
	for ($i = 0; $i < count($grid); $i++)
	{
		$grid[$lefti][$i] = min($grid[$lefti][$i], $r[$i]);
	}
	return array($clusters, $grid);
}
# list all members of this cluster
function members()
{
	$m = array();
	foreach (array($this->left, $this->right) as $x)
	{
		if (method_exists($x, 'members'))
			$m = array_merge($m, $x->members());
		else
			$m[] = $x;
	}
	return $m;
}
# split a cluster into n sub-clusters based on the order they were built (and thus distance)
function splitInto($n)
{
	$clusters = array($this);
	while (count($clusters) < $n)
	{
		# find the cluster with the highest nth
		usort($clusters,
			function ($a, $b)
			{
				if (!property_exists($a, 'distance'))
					return 1;
				if (!property_exists($b, 'distance'))
					return -1;
				return $a->distance - $b->distance;
			});
 		if (!property_exists($clusters[0], 'left'))
			break; # none left to split, bail out
		# highest nth is at [0], split it into left and right
		# note: it's always guarenteed to be splittable since
		# we check n/nth at the top
		$c = array_shift($clusters);
		$clusters[] = $c->left;
		$clusters[] = $c->right;
	}
	return $clusters;
}
private function sortByDistance($clusters)
{
	# find the cluster with the highest nth
	usort($clusters,
		function ($a, $b)
		{
			if (!property_exists($a, 'distance'))
				return 1;
			if (!property_exists($b, 'distance'))
				return -1;
			return $a->distance - $b->distance;
		});
	return $clusters;
}
# split a cluster into n sub-clusters based on the distance
function splitBy($distance)
{
	$clusters = array($this);
	while (true)
	{
 		if (!property_exists($clusters[0], 'distance') || $clusters[0]->distance < $distance)
			break;
		# highest nth is at [0], split it into left and right
		# note: it's always guarenteed to be splittable since
		# we check n/nth at the top
		$c = array_shift($clusters);
		$clusters[] = $c->left;
		$clusters[] = $c->right;
	}
	return $clusters;
}
}
# given a list of labels and a 2-D grid of distances, iteratively agglomerate
# hierarchical Cluster
function agglomerate($labels, $grid)
{
	$clusters = $labels;
	while (count($clusters) > 1)
	{
		$distances = array(array(1, 0, $grid[1][0]));
		for ($i = 2; $i < count($grid); $i++)
		{
			for ($j = 0; $j < $i; $j++)
			{
				$distances[] = array($i, $j, $grid[$i][$j]);
			}
		}
		usort($distances,
			function ($a, $b) { return $b[2] < $a[2]; });
		list($j, $i, $d) = $distances[0];
		# merge i⇐j
		$c = new Cluster($d);
		list($clusters, $grid) = $c->add($clusters, $grid, $i, $j);
		$clusters[$i] = $c;
	}
	return $clusters[min(0, count($clusters)-1)];
}


$ItalyCities = array('php', 'programming', 'java', 'javascript', 'political', 'newton');
$ItalyDistances = array(
	array(   0,   10,  111, 50,  900, 900 ),
	array(   10,  0,   10,  10,  900, 900),
	array(   111, 10,  0,   111, 900, 900),
	array(   50,  10,  754, 0,   900, 900),
	array(   900, 900, 564, 900, 0,   900),
	array(   900, 900, 138, 900, 900, 0),
);                
/*$a = agglomerate($ItalyCities, $ItalyDistances);
echo $a . "\n";
print_r($a);
echo "members: ";
print_r($a->members());


echo "<br>";
echo "splitInto(2): ";
print_r($a->splitInto(2));
*/
for ($i = 1; $i < count($ItalyCities); $i++)
{
	for ($j = 0; $j < $i; $j++)
	{
		$distances[] = array($i, $j, $ItalyDistances[$i][$j]);
	}
}
echo "<pre>";
print_r($ItalyDistances);
echo "</pre>";

?>
