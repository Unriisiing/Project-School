package entity;

import main.GamePanel;
import main.KeyHandler;
import main.UtilityTool;

import java.awt.*;
import javax.imageio.ImageIO;
import java.awt.image.BufferedImage;
import java.io.IOException;

public class Player extends Entity {

    private UtilityTool uTool;
    KeyHandler keyH;
    private boolean isMoving = false;
    private boolean isHealing = false;
    private BufferedImage[] healingAnimationFrames;
    private int healingAnimationCounter = 0;
    public final int screenX;
    public final int screenY;

    public Player(GamePanel gp, KeyHandler keyH) {

        super(gp);

        this.keyH = keyH;
        screenX = gp.screenWidth / 2 - (gp.tileSize / 2);
        screenY = gp.screenHeight / 2 - (gp.tileSize / 2);

        solidArea = new Rectangle();
        solidArea.x = 20;
        solidArea.y = 32;
        solidAreaDefaultX = solidArea.x;
        solidAreaDefaultY = solidArea.y;
        solidArea.width = 20;
        solidArea.height = 20;

        setDefaultValues();
        setupSpriteSheetFrames("champion_walk","champion/", 4, 8, gp.tileSize);

      }

    public void setDefaultValues() {
        worldX = gp.tileSize * 23;
        worldY = gp.tileSize * 21;
        speed = 4;
        direction = "down";

        maxLife = 16;
        life = maxLife;
    }

    public void update() {
        isMoving = keyH.upPressed || keyH.downPressed || keyH.leftPressed || keyH.rightPressed;

        if (isMoving) {
            if (keyH.upPressed) {
                direction = DIRECTION_UP;
            } else if (keyH.downPressed) {
                direction = DIRECTION_DOWN;
            } else if (keyH.leftPressed) {
                direction = DIRECTION_LEFT;
            } else if (keyH.rightPressed) {
                direction = DIRECTION_RIGHT;
            }
            //TILE COLLISION
            collisionOn = false;
            gp.cChecker.checkTile(this);
            //OBJECT COLLISION
            int objIndex = gp.cChecker.checkObject(this, true);
            pickUpObject(objIndex);
            //NPC COLLISION
            int npcIndex = gp.cChecker.checkEntity(this,gp.npc);
            interactNPC(npcIndex);

            //EVENT
            gp.eHandler.checkEvent();
            // IF FALSE PLAYER CAN'T MOVE
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
    }
    public void pickUpObject(int i) {
        if (i != 999) {
            String objectName = gp.obj[i].name;

        }
    }

    public void interactNPC(int i){
        if (i != 999) {

            if(gp.keyH.enterPressed){
                gp.gameState = gp.dialogueState;
                gp.npc[i].speak();
            }
        }
        gp.keyH.enterPressed = false;
    }

    public void draw(Graphics2D g2) {
        BufferedImage image = switch (direction) {
            case DIRECTION_UP -> getUpFrame();
            case DIRECTION_DOWN -> getDownFrame();
            case DIRECTION_LEFT -> getLeftFrame();
            case DIRECTION_RIGHT -> getRightFrame();
            default -> null;
        };

        if (image != null) {
            g2.drawImage(image, screenX, screenY, null);
        }
    }
}
