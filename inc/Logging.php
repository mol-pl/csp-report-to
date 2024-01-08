<?php
/**
 * Reports logging.
 */
class Logging
{
	private $directoryPath;
	private $file;

	public function __construct($directoryPath, $file = 'report.log')
	{
		$this->directoryPath = rtrim($directoryPath, '/') . '/';
		$this->file = preg_replace('#([\/]+|\\.{2,})#', '_', $file);
	}

	/** Report JSON (raw). */
	public function append($data)
	{
		// Get the current date
		$currentDate = date('Y-m');

		// Create the directory if it doesn't exist
		$fullDirectoryPath = $this->directoryPath . "{$currentDate}/";
		if (!file_exists($fullDirectoryPath)) {
			mkdir($fullDirectoryPath, 0777, true);
		}

		// Append the raw data to the file
		$filePath = "{$fullDirectoryPath}{$this->file}";
		file_put_contents($filePath, "\n".$data, FILE_APPEND);
	}
}
