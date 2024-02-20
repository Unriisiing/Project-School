package entity;

import java.awt.*;
import java.awt.image.BufferedImage;
import java.io.IOException;

import main.UtilityTool;

import javax.imageio.ImageIO;

public abstract class Entity {

    public int worldX, worldY;
    public int speed;
    public String direction;
    public int spriteCounter = 0;
    public int spriteNum = 1;
    public Rectangle solidArea;
    public int solidAreaDefaultX, solidAreaDefaultY;
    public boolean collisionOn = false;
    public int maxLife;
    public int life;

    protected BufferedImage[][] spriteSheetFrames;


    protected void setupSpriteSheetFrames(String sheetName, int rows, int cols, int tileSize) {
        UtilityTool uTool = new UtilityTool();
        spriteSheetFrames = new BufferedImage[rows][cols];

        try {
            BufferedImage spriteSheet = ImageIO.read(getClass().getClassLoader().getResourceAsStream("champion/" + sheetName + ".png"));

            int frameWidth = spriteSheet.getWidth() / cols;
            int frameHeight = spriteSheet.getHeight() / rows;

            for (int row = 0; row < rows; row++) {
                for (int col = 0; col < cols; col++) {
                    spriteSheetFrames[row][col] = spriteSheet.getSubimage(col * frameWidth, row * frameHeight, frameWidth, frameHeight);
                    spriteSheetFrames[row][col] = uTool.scaleImage(spriteSheetFrames[row][col], tileSize, tileSize);
                }
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
    public BufferedImage getUpFrame() {
        return spriteSheetFrames[0][spriteNum - 1];
    }

    public BufferedImage getLeftFrame() {
        return spriteSheetFrames[1][spriteNum - 1];
    }

    public BufferedImage getDownFrame() {
        return spriteSheetFrames[2][spriteNum - 1];
    }

    public BufferedImage getRightFrame() {
        return spriteSheetFrames[3][spriteNum - 1];
    }
}

