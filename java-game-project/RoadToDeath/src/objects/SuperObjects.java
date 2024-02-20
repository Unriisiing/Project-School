package objects;

import main.GamePanel;
import main.UtilityTool;

import javax.imageio.ImageIO;
import java.awt.*;
import java.awt.image.BufferedImage;
import java.io.IOException;

public abstract class SuperObjects {

    public BufferedImage image;
    public String name;
    public boolean collision = false;
    public int worldX , worldY ;
    public Rectangle solidArea = new Rectangle(0,0,48,48);
    public int solidAreaDefaultX = 0;
    public int solidAreaDefaultY = 0;
    UtilityTool uTool = new UtilityTool();
    protected BufferedImage[][] spriteSheetFrames;
    public BufferedImage fullHeart, halfHeart, zeroHeart;



    public void draw(Graphics2D g2, GamePanel gp){

        int screenX = worldX - gp.player.worldX + gp.player.screenX;
        int screenY = worldY - gp.player.worldY + gp.player.screenY;

        if(        worldX + gp.tileSize > gp.player.worldX - gp.player.screenX
                && worldX - gp.tileSize< gp.player.worldX + gp.player.screenX
                && worldY + gp.tileSize> gp.player.worldY - gp.player.screenY
                && worldY - gp.tileSize< gp.player.worldY + gp.player.screenY){

            g2.drawImage(image, screenX , screenY , gp.tileSize , gp.tileSize, null );
        }

    }

    protected void setupSpriteSheetFrames(String sheetName, int rows, int cols, int tileSize, double scaleFactor) {
        UtilityTool uTool = new UtilityTool();
        spriteSheetFrames = new BufferedImage[rows][cols];

        try {
            BufferedImage spriteSheet = ImageIO.read(getClass().getClassLoader().getResourceAsStream(sheetName));

            int frameWidth = spriteSheet.getWidth() / cols;
            int frameHeight = spriteSheet.getHeight() / rows;

            for (int row = 0; row < rows; row++) {
                for (int col = 0; col < cols; col++) {
                    spriteSheetFrames[row][col] = spriteSheet.getSubimage(col * frameWidth, row * frameHeight, frameWidth, frameHeight);
                    spriteSheetFrames[row][col] = uTool.scaleImage(spriteSheetFrames[row][col], (int) (tileSize * scaleFactor), (int) (tileSize * scaleFactor));
                }
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }


}