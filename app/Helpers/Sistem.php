<?php

namespace App\Helpers;

class Sistem
{

	public static function date_indo($tgl)
	{
		$ubah = gmdate($tgl, time() + 60 * 60 * 8);
		$pecah = explode("-", $ubah);
		$tanggal = $pecah[2];
		$bulan = Sistem::bulan($pecah[1]);
		$tahun = $pecah[0];
		return $tanggal . ' ' . $bulan . ' ' . $tahun;
	}
	public static function bulan($bln)
	{
		switch ($bln) {
			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
	public static function format_tanggal()
	{
		return date("Y-m-d");
	}

	public static function format_tanggal2()
	{
		return date("d-m-Y");
	}

	public static function format_tanggal_jam()
	{
		return date("d-m-Y H:i");
	}

	public static function jam_menit($time)
	{
		$exp = explode(':', $time);
		if (count($exp) == 3) {
			$date = $exp[0] . ':' . $exp[1];
		}
		return $date;
	}
	public static function tgl_sql($date)
	{
		$exp = explode('-', $date);
		if (count($exp) == 3) {
			$date = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
		}
		return $date;
	}
	public static function tgl_sql2($date)
	{
		$exp = explode('/', $date);
		if (count($exp) == 3) {
			$date = $exp[2] . '/' . $exp[1] . '/' . $exp[0];
		}
		return $date;
	}
	public static function tgl_indo($date)
	{
		$exp = explode('-', $date);
		if (count($exp) == 3) {
			$date = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
		}
		return $date;
	}
	public static function insert_nominal($data)
	{
		$exp = explode(".", $data);
		if (count($exp) == 1) {
			$hasil = $exp[0];
		}
		if (count($exp) == 2) {
			$hasil = $exp[0] . $exp[1];
		}
		if (count($exp) == 3) {
			$hasil = $exp[0] . $exp[1] . $exp[2];
		}
		if (count($exp) == 4) {
			$hasil = $exp[0] . $exp[1] . $exp[2] . $exp[3];
		}
		if (count($exp) == 5) {
			$hasil = $exp[0] . $exp[1] . $exp[2] . $exp[3] . $exp[4];
		}
		if (count($exp) == 6) {
			$hasil = $exp[0] . $exp[1] . $exp[2] . $exp[3] . $exp[4] . $exp[5];
		}
		if (count($exp) == 7) {
			$hasil = $exp[0] . $exp[1] . $exp[2] . $exp[3] . $exp[4] . $exp[5] . $exp[6];
		}
		if (count($exp) > 7) {
			$hasil = "UNDEFINED";
		}
		return $hasil;
	}

	public static function konversitanggal($tanggal)
	{
		date_default_timezone_set('Asia/Jakarta');
		$format = array(
			'Sun' => 'Minggu', 'Mon' => 'Senin', 'Tue' => 'Selasa', 'Wed' => 'Rabu', 'Thu' => 'Kamis', 'Fri' => 'Jumat', 'Sat' => 'Sabtu', 'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 'Apr' => 'April', 'May' => 'Mei', 'Jun' => 'Juni', 'Jul' => 'Juli', 'Aug' => 'Agustus', 'Sep' => 'September', 'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember'
		);
		$tanggal = date('D, d M Y', strtotime($tanggal));
		return strtr($tanggal, $format);
	}
	public static function converttanggal($tanggal)
	{
		date_default_timezone_set('Asia/Jakarta');
		$format = array('Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 'Apr' => 'April', 'May' => 'Mei', 'Jun' => 'Juni', 'Jul' => 'Juli', 'Aug' => 'Agustus', 'Sep' => 'September', 'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember');
		$tanggal = date('d M Y', strtotime($tanggal));
		return strtr($tanggal, $format);
	}

	public static function time_since($timestamp)
	{
		date_default_timezone_set('Asia/Jakarta');
		$selisih = time() - strtotime($timestamp);
		$detik = $selisih;
		$menit = round($selisih / 60);
		$jam = round($selisih / 3600);
		$hari = round($selisih / 86400);
		$minggu = round($selisih / 604800);
		$bulan = round($selisih / 2419200);
		$tahun = round($selisih / 29030400);
		if ($detik <= 60) {
			$waktu = $detik . ' sec';
		} else if ($menit <= 60) {
			$waktu = $menit . ' min';
		} else if ($jam <= 24) {
			$waktu = $jam . ' hrs';
		} else if ($hari <= 7) {
			$waktu = $hari . ' day';
		} else if ($minggu <= 4) {
			$waktu = $minggu . ' weeks';
		} else if ($bulan <= 12) {
			$waktu = $bulan . ' month';
		} else {
			$waktu = $tahun . ' years';
		}
		return $waktu;
	}

	public static function tgl_indo_timestamp($tgl)
	{
		date_default_timezone_set('Asia/Jakarta');
		//inttime=date('Y-m-d H:i:s',$tgl); //mengubah format menjadi tanggal biasa
		$inttime = date($tgl); //mengubah format menjadi tanggal biasa
		$tglBaru = explode(" ", $inttime); //memecah berdasarkan spaasi

		$tglBaru1 = $tglBaru[0]; //mendapatkan variabel format yyyy-mm-dd
		$tglBaru2 = $tglBaru[1]; //mendapatkan fotmat hh:ii:ss
		$tglBarua = explode("-", $tglBaru1); //lalu memecah variabel berdasarkan -

		$tgl = $tglBarua[2];
		$bln = $tglBarua[1];
		$thn = $tglBarua[0];

		$bln = Sistem::bulan($bln); //mengganti bulan angka menjadi text dari fungsi bulan
		$ubahTanggal = "$tgl $bln $thn | $tglBaru2 "; //hasil akhir tanggal

		return $ubahTanggal;
	}
	public static function tgl_indo_timestamp_v2($tgl)
	{
		date_default_timezone_set('Asia/Jakarta');
		//inttime=date('Y-m-d H:i:s',$tgl); //mengubah format menjadi tanggal biasa
		$inttime = date($tgl); //mengubah format menjadi tanggal biasa
		$tglBaru = explode(" ", $inttime); //memecah berdasarkan spaasi

		$tglBaru1 = $tglBaru[0]; //mendapatkan variabel format yyyy-mm-dd
		$tglBaru2 = $tglBaru[1]; //mendapatkan fotmat hh:ii:ss
		$tglBarua = explode("-", $tglBaru1); //lalu memecah variabel berdasarkan -

		$tgl = $tglBarua[2];
		$bln = $tglBarua[1];
		$thn = $tglBarua[0];

		// $bln=Sistem::bulan($bln); //mengganti bulan angka menjadi text dari fungsi bulan
		$time = Sistem::jam_menit($tglBaru2);
		$ubahTanggal = "$tgl-$bln-$thn | $time"; //hasil akhir tanggal

		return $ubahTanggal;
	}
	public static function format_rupiah($angka)
	{
		$rupiah = "";
		$rp = strlen($angka);
		while ($rp > 3) {
			$rupiah = "." . substr($angka, -3) . $rupiah;
			$s = strlen($angka) - 3;
			$angka = substr($angka, 0, $s);
			$rp = strlen($angka);
		}
		$rupiah = "Rp " . $angka . $rupiah . "";
		return $rupiah;
	}

	public static function get_title($url)
	{
		$str = file_get_contents($url);
		if (strlen($str) > 0) {
			$str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
			preg_match('/\<title\>(.*)\<\/title\>/i', $str, $title); // ignore case
			return $title[1];
		}
	}

	public static function check_space($data)
	{
		$text = preg_replace("![^a-z0-9]+!i", "-", $data); // kode untuk menghilangkan spasi
		return $text;
	}

	public static function replace_kata($data)
	{
		$text = str_replace(' ', '', $data); // kode untuk menghilangkan spasi
		return $text;
	}
}
