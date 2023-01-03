

<?php
/** TUGAS PERTAMA LOGIQUE */

echo 'Tugas Nomor 1 : <br>';
function is_prime($n) {
  // Jika bilangan kurang dari 2, maka tidak merupakan bilangan prima
  if ($n < 2) {
    return false;
  }

  // Cari pembagi terdekat dari n yang lebih kecil dari akar n
  for ($i = 2; $i <= sqrt($n); $i++) {
    // Jika n dapat dibagi habis oleh i, maka n bukan bilangan prima
    if ($n % $i == 0) {
      return false;
    }
  }

  // Jika tidak ditemukan pembagi yang dapat membagi habis n, maka n merupakan bilangan prima
  return true;
}

if (is_prime(7)) {
  echo "7 adalah bilangan prima";
} else {
  echo "7 bukan bilangan prima";
}

/** ===================*/
echo "<hr>";

echo 'Tugas Nomor 2 : <br>';

error_reporting(0);
$nilai = Array(11, 6, 31, 201, 99, 861, 1, 7, 14, 79);         
echo 'Nilai terbesar dari bilangan Array adalah ' . max($nilai);

/** ===================*/
echo "<hr>";

echo 'Tugas Nomor 3 : <br>';

function print_pattern($n) {
  // Lakukan perulangan dari 1 sampai n
  for ($i = 1; $i <= $n; $i++) {
    // Lakukan perulangan dari 1 sampai i
    for ($j = 1; $j <= $i; $j++) {
      // Cetak nilai j dan tambahkan spasi setelahnya
      echo $j . " ";
    }
    // Pindah baris setelah selesai mencetak baris i
    echo "<br>";
  }
}
print_pattern(8);

echo "<hr>";
echo 'Tugas Nomor 4 : <br>';

$is_sort = array(99, 2, 64, 8, 111, 33, 65, 11, 102, 50);
sort($is_sort);

$arrlength = count($is_sort);
for($x = 0; $x < $arrlength; $x++) {
  echo $is_sort[$x];
  echo "<br>";
}

echo "<hr>";
echo "Tugas Nomor 5 : <br>";

function printOutput($n) {
  // Lakukan perulangan dari 1 sampai n
  for ($i = 1; $i <= $n; $i++) {
    // Lakukan perulangan dari 1 sampai n
    for ($j = 1; $j <= $n; $j++) {
      // Cetak nilai (i-1) + (j-1) * n dan tambahkan spasi setelahnya
      echo (($i - 1) + ($j - 1) * $n) . " ";
    }
    // Pindah baris setelah selesai mencetak baris i
    echo "<br>";
  }
}

printOutput(4);

?>