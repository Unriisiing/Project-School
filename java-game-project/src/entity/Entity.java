package entity;

import java.awt.*;
import java.awt.image.BufferedImage;
import java.io.IOException;

import main.GamePanel;
import main.UtilityTool;

import javax.imageio.ImageIO;

public abstract class Entity {
    GamePanel gp;
    public int worldX, worldY;
    public int speed;
    public String direction;
    public int spriteCounter = 0;
    public int spriteNum = 1;
    public int actionLockCounter = 0;
    public Rectangle solidArea = new Rectangle(0,0,64,64);
    public int solidAreaDefaultX, solidAreaDefaultY;
    public boolean collisionOn = false;
    protected BufferedImage[][] spriteSheetFrames;
    public static final String DIRECTION_UP = "up";
    public static final String DIRECTION_DOWN = "down";
    public static final String DIRECTION_LEFT = "left";
    public static final String DIRECTION_RIGHT = "right";
    String dialogues[] = new String[20];
    int dialogueIndex = 0;

    //CHARACTER STATUS
    public int maxLife;
    public int life;


    public Entity(GamePanel gp){
        this.gp = gp;
    }
    public void setAction(){}
    public void speak(){
        if(dialogues[dialogueIndex]==null){
            dialogueIndex = 0;
        }
        gp.ui.currentDialogue = dialogues[dialogueIndex];
        dialogueIndex++;

        switch(gp.player.direction){
            case "up":
                direction="down";
                break;
            case "down":
                direction="up";
                break;
            case "left":
                direction="right";
                break;
            case "right":
                direction="left";
                break;
        }
    }
    public void update(){
        setAction();
        collisionOn = false;
        gp.cChecker.checkTile(this);
        gp.cChecker.checkObject(this,false);
        gp.cChecker.checkPlayer(this);


        if (collisionOn == false) {
            switch (direction) {
                case DIRECTION_UP:
                    worldY -= speed;
                    break;
                case DIRECTION_DOWN:
                    worldY += speed;
                    break;
                case DIRECTION_LEFT:
                    worldX -= speed;
                    break;
                case DIRECTION_RIGHT:
                    worldX += speed;
                    break;
            }
        }

        spriteCounter++;
        if (spriteCounter > 8) {
            spriteNum = (spriteNum % 8) + 1;
            spriteCounter = 0;
        } else {
            spriteCounter++;
            if (spriteCounter > 16) {
                spriteNum = (spriteNum % 2) + 1;
                spriteCounter = 0;
            }
        }
    }
    public void draw(Graphics2D g2){
        int screenX = worldX - gp.player.worldX + gp.player.screenX;
        int screenY = worldY - gp.player.worldY + gp.player.screenY;

        if(        worldX + gp.tileSize > gp.player.worldX - gp.player.screenX
                && worldX - gp.tileSize< gp.player.worldX + gp.player.screenX
                && worldY + gp.tileSize> gp.player.worldY - gp.player.screenY
                && worldY - gp.tileSize< gp.player.worldY + gp.player.screenY){

            BufferedImage image = switch (direction) {
                case DIRECTION_UP -> getUpFrame();
                case DIRECTION_DOWN -> getDownFrame();
                case DIRECTION_LEFT -> getLeftFrame();
                case DIRECTION_RIGHT -> getRightFrame();
                default -> null;
            };

            g2.drawImage(image, screenX , screenY , gp.tileSize , gp.tileSize, null );
        }
    }

    protected void setupSpriteSheetFrames(String sheetName, String folder, int rows, int cols, int tileSize) {
        UtilityTool uTool = new UtilityTool();
        spriteSheetFrames = new BufferedImage[rows][cols];

        try {
            BufferedImage spriteSheet = ImageIO.read(getClass().getClassLoader().getResourceAsStream(folder + sheetName + ".png"));

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

