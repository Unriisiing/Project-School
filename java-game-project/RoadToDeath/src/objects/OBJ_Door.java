package objects;

import main.GamePanel;

import javax.imageio.ImageIO;
import java.io.IOException;

public class OBJ_Door extends SuperObjects {
    GamePanel gp;
    public OBJ_Door(GamePanel gp){
        name = "Door";

        try{
            image = ImageIO.read(getClass().getClassLoader().getResourceAsStream("objects/door.png"));
            uTool.scaleImage(image, gp.tileSize, gp.tileSize);
        }catch (IOException e){
            e.printStackTrace();
        }
        collision = true;
    }
}
