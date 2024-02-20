package tile;

import main.GamePanel;
import main.UtilityTool;

import javax.imageio.ImageIO;
import java.awt.*;
import java.awt.image.BufferedImage;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;

public class TileManager {

    GamePanel gp;
    public Tile[] tile;
    public int[][] mapTileNum;


    public TileManager(GamePanel gp){
        this.gp = gp;
        //number of differents tiles
        tile = new Tile[100];

        mapTileNum = new int[gp.maxWorldCol][gp.maxWorldRow];

        getTileImage();
        loadMap("maps/worldV2.txt");
    }

    public void getTileImage(){

        setUp(0,"grass00",false , "tiles/worldmap/");
        setUp(1,"grass00",false , "tiles/worldmap/");
        setUp(2,"grass00",false , "tiles/worldmap/");
        setUp(3,"grass00",false , "tiles/worldmap/");
        setUp(4,"grass00",false , "tiles/worldmap/");
        setUp(5,"grass00",false , "tiles/worldmap/");
        setUp(6,"grass00",false , "tiles/worldmap/");
        setUp(7,"grass00",false , "tiles/worldmap/");
        setUp(8,"grass00",false , "tiles/worldmap/");
        setUp(9,"grass00",false , "tiles/worldmap/");
        setUp(10,"grass00",false , "tiles/worldmap/");
        setUp(11,"grass01",false , "tiles/worldmap/");
        setUp(12,"water00",true , "tiles/worldmap/");
        setUp(13,"water01",true , "tiles/worldmap/");
        setUp(14,"water02",true , "tiles/worldmap/");
        setUp(15,"water03",true , "tiles/worldmap/");
        setUp(16,"water04",true , "tiles/worldmap/");
        setUp(17,"water05",true , "tiles/worldmap/");
        setUp(18,"water06",true , "tiles/worldmap/");
        setUp(19,"water07",true , "tiles/worldmap/");
        setUp(20,"water08",true , "tiles/worldmap/");
        setUp(21,"water09",true , "tiles/worldmap/");
        setUp(22,"water10",true , "tiles/worldmap/");
        setUp(23,"water11",true , "tiles/worldmap/");
        setUp(24,"water12",true , "tiles/worldmap/");
        setUp(25,"water13",true,  "tiles/worldmap/");
        setUp(26,"road00",false, "tiles/worldmap/");
        setUp(27,"road01",false, "tiles/worldmap/");
        setUp(28,"road02",false, "tiles/worldmap/");
        setUp(29,"road03",false, "tiles/worldmap/");
        setUp(30,"road04",false, "tiles/worldmap/");
        setUp(31,"road05",false, "tiles/worldmap/");
        setUp(32,"road06",false, "tiles/worldmap/");
        setUp(33,"road07",false, "tiles/worldmap/");
        setUp(34,"road08",false, "tiles/worldmap/");
        setUp(35,"road09",false, "tiles/worldmap/");
        setUp(36,"road10",false, "tiles/worldmap/");
        setUp(37,"road11",false, "tiles/worldmap/");
        setUp(38,"road12",false, "tiles/worldmap/");
        setUp(39,"earth",false,"tiles/worldmap/");
        setUp(40,"wall",true , "tiles/worldmap/");
        setUp(41,"tree",true , "tiles/worldmap/");
        setUp(42,"mur",true , "tiles/castletiles/");
        setUp(43,"porte1",true , "tiles/castletiles/");
        setUp(44,"mur2",true , "tiles/castletiles/");
        setUp(45,"mur4",true , "tiles/castletiles/");
        setUp(46,"mur(1)",true , "tiles/castletiles/");
        setUp(47,"mur(2)",true , "tiles/castletiles/");
        setUp(48,"mur(3)",true , "tiles/castletiles/");
        setUp(49,"mur49",true , "tiles/castletiles/");
        setUp(50,"top",true , "tiles/castletiles/");
        setUp(51,"flag",true , "tiles/castletiles/");
        setUp(52,"flag2",true , "tiles/castletiles/");
        setUp(53,"flag_dead",true , "tiles/castletiles/");
        setUp(54,"swamp",true , "tiles/SwampTiles/");





    }
    public void setUp(int index, String imagePath, boolean collision, String folder){
        UtilityTool uTool = new UtilityTool();

        try{
            tile[index] = new Tile();
            tile[index].image = ImageIO.read(getClass().getClassLoader().getResourceAsStream(folder + imagePath +".png"));
            tile[index].image = uTool.scaleImage(tile[index].image,gp.tileSize,gp.tileSize);
            tile[index].collision = collision;
        }catch(IOException e){
            e.printStackTrace();
        }
    }
    public void loadMap(String filepath){
        try{
            InputStream is = getClass().getClassLoader().getResourceAsStream(filepath);
            BufferedReader br = new BufferedReader(new InputStreamReader(is));


            int col = 0;
            int row = 0;

            while(col < gp.maxWorldCol && row < gp.maxWorldRow){
                String line = br.readLine();

                while(col < gp.maxWorldCol){
                    String numbers[] = line.split(" ");

                    int num = Integer.parseInt(numbers[col]);

                    mapTileNum[col][row] = num;
                    col++;

                }
                if(col == gp.maxWorldCol){
                    col = 0;
                    row++;

                }
            }
            br.close();
        }catch(Exception e){
            e.printStackTrace(); // Print the exception trace
        }

    }
    public void draw(Graphics2D g2){


        int worldCol = 0;
        int worldRow = 0;


        while(worldCol < gp.maxWorldCol && worldRow < gp.maxWorldRow){

            int tileNum = mapTileNum[worldCol][worldRow];

            int worldX = worldCol * gp.tileSize;
            int worldY = worldRow * gp.tileSize;
            int screenX = worldX - gp.player.worldX + gp.player.screenX;
            int screenY = worldY - gp.player.worldY + gp.player.screenY;

            if(        worldX + gp.tileSize > gp.player.worldX - gp.player.screenX
                    && worldX - gp.tileSize< gp.player.worldX + gp.player.screenX
                    && worldY + gp.tileSize> gp.player.worldY - gp.player.screenY
                    && worldY - gp.tileSize< gp.player.worldY + gp.player.screenY){

                g2.drawImage(tile[tileNum].image, screenX , screenY , gp.tileSize , gp.tileSize, null );
            }

            worldCol++;


            if(worldCol == gp.maxWorldCol){
                worldCol=0;
                worldRow++;

            }
        }
    }
}
