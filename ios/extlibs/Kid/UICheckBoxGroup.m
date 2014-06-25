//
//  UICheckBoxGroup.m
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-11-13.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import "UICheckBoxGroup.h"

@implementation UICheckBoxGroup
@synthesize groupType;

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        // Initialization code
    }
    return self;
}

- (void) didCreateViewComplete
{
    int i = 0;
    for (UICheckBox *item in self.itemList)
    {
        [item setTag:i];
        [item addVelueChangeDelegate:self];
        i++;
    }
}

-(void) setGroupShowType:(int) type
{
    self.groupType = type;
}

-(void) setDelegate:(id<UICheckBoxGroupDelegate>) delegate
{
    if(delegate)
    {
        self.myDelegate = delegate;
    }
}

- (void) didCheckBoxValeuChange:(id)sender isChecked:(BOOL)isCheckedValue
{
    UICheckBox *checkBox = (UICheckBox *) sender;
    [self setShowItemByIndex:checkBox.tag];
    if(self.myDelegate)
    {
        //[self.myDelegate didUICheckBoxGroupValeuChange:self UICheckBox:sender isChecked:isCheckedValue];
        [self.myDelegate didUICheckBoxGroupValeuChange:self UICheckBox:sender];
    }
}

-(void) setShowItemByIndex:(int)index
{
    for (int i = 0; i < [self.itemList count]; i++)
    {
        UICheckBox *item = [itemList objectAtIndex:i];
        if(i == index)
        {
            [item setCheckBoxIsSelected:YES];
        }
        else
        {
            [item setCheckBoxIsSelected:NO];
        }
    }
}
/*
// Only override drawRect: if you perform custom drawing.
// An empty implementation adversely affects performance during animation.
- (void)drawRect:(CGRect)rect
{
    // Drawing code
}
*/

@end
