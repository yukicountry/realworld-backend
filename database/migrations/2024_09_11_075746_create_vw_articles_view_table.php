<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sql = <<<EOT
                CREATE VIEW vw_articles AS
                SELECT
                    articles.*,
                    COALESCE(vw_favorites_count.count, 0) AS favorites_count,
                    users.username AS author_username
                FROM
                    articles
                JOIN
                    users ON articles.author_id = users.id
                LEFT JOIN
                    vw_favorites_count ON articles.slug = vw_favorites_count.slug;
            EOT;

        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $sql = <<<EOT
                DROP VIEW IF EXISTS vw_articles;
            EOT;

        DB::statement($sql);
    }
};
