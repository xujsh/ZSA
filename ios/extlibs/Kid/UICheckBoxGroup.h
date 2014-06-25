//
//  UICheckBoxGroup.h
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-11-13.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "UIViewGroup.h"
#import "UICheckBox.h"

#define GROUPTYPE_CHECKBOX 0
#define GROUPTYPE_RADIOBOX 1

@protocol UICheckBoxGroupDelegate

//- (void) didUICheckBoxGroupValeuChange:(id)sender UICheckBox:(id)checkBox isChecked:(BOOL) isCheckedValue;
- (void) didUICheckBoxGroupValeuChange:(id)sender UICheckBox:(id)checkBox;
@end

//@interface UICheckBoxGroup : UIView <UICheckBoxDelegate>
@interface UICheckBoxGroup : UIViewGroup <UICheckBoxDelegate>
{
    //NSArray *itemList;
    int groupType;
}


//@property (nonatomic, retain) NSArray *itemList;
@property (assign) int groupType;
@property (nonatomic, assign) id<UICheckBoxGroupDelegate> myDelegate;

-(void) setDelegate:(id<UICheckBoxGroupDelegate>) delegate;
-(void) setShowItemByIndex:(int)index;

@end
