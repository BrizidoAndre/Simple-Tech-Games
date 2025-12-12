<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "games".
 *
 * @property int $id
 * @property string $image_path
 * @property string $valid_date (y-m-d)
 * @property int $number_pieces
 *
 * @property Pieces[] $pieces
 * @property Solution[] $solutions
 */
class Games extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $popCount;
    const IMAGE_SIZE = 1024;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'games';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['image_path', 'default', 'value' => 'qualquercoisa'],
            [['valid_date', 'number_pieces', 'imageFile'], 'required'],
            [['valid_date'], 'safe'],
            [['valid_date'], 'unique'],
            ['imageFile', 'image', 'maxWidth' => self::IMAGE_SIZE, 'minWidth' => self::IMAGE_SIZE, 'minHeight' => self::IMAGE_SIZE, 'maxHeight' => self::IMAGE_SIZE],
            [['number_pieces'], 'integer'],
            [['image_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * # Upload de imagens
     * Salva no banco de dados realizando a verificação dos validadores
     * ## Se não for válida
     * O modelo não é salvo e retorna ao usuário as mensagens de erro
     *
     * ## Se for válido
     * Uma pasta é criada onde ficará todas as imagens referêntes a imagem enviada pelo usuário
     * - A imagem pura é salva no servidor
     * - Um nome aleatório é definido para esta imagem
     * - Um Imagick é criado com base na imagem pura
     * - Outro imagic é clonado a partir do primero, este será o responsável por salvar a imagem com blur
     * _________
     * Após **salvar** esse segundo imagic começa a lógica das partes da imagem.
     * Obtemos a raíz da quantidade do número de peças
     * Definimos a largura e altura da imagem com base na IMAGE_SIZE (1024) / raíz do nº de peças
     * criamos dois laços de repetição para definir a posição vertical e horizontal de onde estamos tirando as imagens
     * dentor dos dois laços de repetição criamos um clone dinamicamente e a partir da imagem original "recortamos um pedaço" usando a posição x e y
     * por fim criamo um nome aleatório para o arquivo e salvamos um registro desse pedaço da imagem no banco de dados
     * @return bool
     * @throws \ImagickException
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function upload()
    {
        if ($this->save()) {
            // criar diretório e url
            $folder = 'imgs/' . Yii::$app->security->generateRandomString(10);
            FileHelper::createDirectory($folder);
            $url = $folder . '/' . Yii::$app->security->generateRandomString(32) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($url);
            // obtendo a foto
            // começa a usar o imagick
            $magick = new \Imagick($url);
            $this->image_path = $url;

            // Lógica do blur
            //clonando a imagem original para não perder a referência
            $blur = $magick->clone();
            // criando o efeito de blur
            $blur->blurImage(0, 50);
            // salvando o caminho da imagem com blur;
            $blurPath = $folder . '/blur_' . Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
            $blur->writeImage($blurPath);


            // Lógica do crop
            // a largura e altura sempre será 1024 píxels
            $root = sqrt($this->number_pieces);
            $imageCrop = self::IMAGE_SIZE / $root;
            for ($i = 0; $i < $root; $i++) {
                $positionX = $i * $imageCrop;
                for ($j = 0; $j < $root; $j++) {
                    $positionY = $j * $imageCrop;
                    $crop = $magick->clone();
                    $crop->cropImage($imageCrop, $imageCrop, $positionX, $positionY);
                    $fileName = Yii::$app->security->generateRandomString(12);
                    $filePathTotal = $folder . '/' . $fileName . '.' . $this->imageFile->extension;
                    $crop->writeImage($filePathTotal);
                    $piece = new Pieces([
                        'game_id' => $this->id,
                        'url' => $filePathTotal,
                        'position' => ($i + 1) + ($j * $root)
                    ]);
                    $piece->save(false);
                }
            }
            $this->save(false);
            return true;
        }

        return false;
    }

    public function uploadGd()
    {
        if ($this->save()) {
            $folder = 'imgs/' . Yii::$app->security->generateRandomString(10);
            FileHelper::createDirectory($folder);
            $url = $folder . '/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($url);
            // obtendo a foto
            // Obtém dois gdimage da mesma url
            // está é a original
            $imageUser = imagecreatefromjpeg($url);
            // está será aplicado o blur
            $blur = imagecreatefromjpeg($url);
            for ($i = 0; $i < 50; $i++) {
                // aplicando o blur no mínimo 20 vezes
                imagefilter($blur, IMG_FILTER_GAUSSIAN_BLUR);
            }
            // salvando a imagem com filtro com prefixo blur no nome do arquivo
            $urlBlur = $folder . '/blur_' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            imagejpeg($blur, $urlBlur);

            // obtendo a quantidade de colunas e linhas com base no número de peças
            $root = sqrt($this->number_pieces);
            // tamanho da imagem
            $imageSize = self::IMAGE_SIZE / $root;
//            repetindo para cada coluna
            for ($i = 0; $i < $root; $i++) {
//                repetindo para cada linha
                for ($j = 0; $j < $root; $j++) {
                    //                                 o x e y equivale a linha e coluna =  i + tamanho da foto
                    $copyImage = imagecrop($imageUser, ['x' => ($i * $imageSize), 'y' => ($j * $imageSize), 'width' => $imageSize, "height" => $imageSize]);
                    // nome da imagem cortada
                    $urlCrop = $folder . '/' . Yii::$app->security->generateRandomString(10) . '.' . $this->imageFile->extension;
                    imagejpeg($copyImage, $urlCrop);
                    // cada pedaço ganha um registro na web
                    $piece = new Pieces([
                        'game_id' => $this->id,
                        'url' => $urlCrop,
                        // sua posição é calculada com base na linha e coluna
                        'position' => ($i + 1) + ($j * $root),
                    ]);
                    $piece->save(false);
                }
            }
            $this->image_path = $url;
            $this->save(false);
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_path' => 'Image Path',
            'date' => 'Date',
            'number_pieces' => 'Number Pieces',
        ];
    }

    /**
     * Gets query for [[Pieces]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPieces()
    {
        return $this->hasMany(Pieces::class, ['game_id' => 'id']);
    }

    /**
     * Gets query for [[Solutions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSolutions()
    {
        return $this->hasMany(Solution::class, ['game_id' => 'id']);
    }

}
