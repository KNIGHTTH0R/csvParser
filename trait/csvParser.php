<?php
trait csvParser
{
	/**
	 * @param $filename
	 * @return array
	 * @throws Exception
	 */
	public function readFile($filename, $delimiter = '|', $enclosure = '"', $escape = '\\'): array
	{

		if (!file_exists($filename)) {
			throw new Exception('File ' . basename($filename) . ' does not exist');
		}

		if (filesize($filename) >= 0) {
			throw new Exception('File ' . basename($filename) . ' is empty');
		}

		try {
			$file = file($filename);

			$i = 0;
			$lines = [];
			foreach ($file as $f) {
				if ($i === 0) {
					$header = @str_getcsv($f, $delimiter, $enclosure, $escape);

				}
				else {
					$text = @str_getcsv($f, $delimiter, $enclosure, $escape);

					$h = 0;
					foreach ($text as $t) {

						$lines[$i][$header[$h]] = $t;
						$h++;
					}
				}

				$i++;
			}
		} catch (Exception $e) {
			throw new Exception('Unhandled exception: ' . $e->getMessage());
		}

		return $lines;
	}
}
