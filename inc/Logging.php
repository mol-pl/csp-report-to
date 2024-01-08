<?php
/**
 * Reports logging.
 */
class Logging
{
	private $directoryPath;

	public function __construct($directoryPath)
	{
		$this->directoryPath = rtrim($directoryPath, '/') . '/';
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
		$filePath = "{$fullDirectoryPath}report.log";
		file_put_contents($filePath, "\n".$data, FILE_APPEND);
	}
}
