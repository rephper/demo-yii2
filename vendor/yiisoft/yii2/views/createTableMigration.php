<?php
/**
 * This view is used by console/controllers/MigrateController.php.
 *
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name without namespace */
/* @var $namespace string the new migration class namespace */
/* @var $table string the name table */
/* @var $tableComment string the comment table */
/* @var $fields array the fields */
/* @var $foreignKeys array the foreign keys */

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use yii\db\Migration;
use common\traits\MigrationOptionsTrait;

/**
 * Handles the creation of table `<?= $table ?>`.
<?= $this->render('_foreignTables', [
    'foreignKeys' => $foreignKeys,
]) ?>
 *
 * @property string $table
 */
class <?= $className ?> extends Migration
{
    use MigrationOptionsTrait;

    private $table = '<?= $table ?>';

    public function __construct(array $config = [])
    {
        parent::__construct($config);
//        $this->db = Yii::$app->db;
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options  = $this->getMysqlOptions('InnoDB');

<?= $this->render('_createTable', [
    'table' => $table,
    'fields' => $fields,
    'foreignKeys' => $foreignKeys,
])
?>

        $this->createIndex('index', $this->table, 'index', false);

        $this->addCommentOnTable($this->table, '');
<?php
if (!empty($tableComment)) {
    echo $this->render('_addComments', [
        'table' => '`$this->table`',
        'tableComment' => $tableComment,
    ]);
}
?>
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
<?= $this->render('_dropTable', [
    'table' => $table,
    'foreignKeys' => $foreignKeys,
])
?>
    }
}