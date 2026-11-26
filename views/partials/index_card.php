<div class="flex flex-col items-center justify-center mb-6">
  <a href="<?= $service['path'] ?>" class="block bg-white rounded-lg border-2 border-red-500 p-4 hover:bg-gray-100 hover:border-red-600 transition duration-300">
    <div class="w-40 h-40 flex items-center justify-center">
      <?php require 'icons/'.$service['svg']; ?>
    </div>
    <h2 class="text-xl mt-4"><?= $service['name'] ?></h2>
  </a>
</div>
